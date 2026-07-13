# ADR 0001: Auth & Identity Model — users, employees, contacts, companies

**Status:** Accepted
**Date:** 2026-07-12
**Context:** Porting SurveyOS from plain PHP (GNCPL) to Laravel with Fortify

## Problem

The legacy PHP project went through two competing identity models over time:

1. `geonexa_schema_v0_8.sql`: a single `users` table with
   `role ENUM('admin','manager','drafter','field','client','viewer')`
   covering both staff and clients, plus a separate `clients` /
   `client_contacts` pair for the actual client relationship.
2. Later tooling (`staff-auth.php`, `client-account-manager.php`,
   `client-portal.php`) abandoned that and introduced parallel,
   never-reconciled tables: `staff_users` for internal login, and
   `client_companies` / `client_company_contacts` /
   `client_company_project_access` for the customer side.

Neither model was ever unified, and there was no clean way to represent
an individual (non-company) client in the newer system. We need one
model, going forward, for the Laravel port.

We also need this to work cleanly with Laravel Fortify, which assumes
by default that a single `users` table drives authentication.

## Decision

**Keep `users` as a thin, Fortify-owned authentication table only** —
`id`, `name`, `email`, `email_verified_at`, `password` (nullable),
`remember_token`, plus a `type` enum (`employee` | `contact`) used
purely as a fast routing signal (which guard/dashboard to send a
logged-in user to). `type` is not a source of truth for permissions.

**Split domain data into two separate profile tables**, each with a
`user_id` foreign key back to `users`:

- `employees` — staff. Holds `position` (office_admin, researcher,
  cad, field, pls) as *descriptive* data only (org chart, licensing,
  who's on the field crew) — not the permission source of truth.
- `contacts` — clients. This is the **primary** client table.
  `company_id` is a **nullable** foreign key to `companies`. An
  individual client is simply a contact with `company_id = NULL` —
  there is no separate "individual client" table and no need to fake
  a one-person company. A solo homeowner and a PM at a survey client
  company go through the identical table and portal code path.

**companies** holds the company-level record and a
`restrict_contacts_to_assigned_projects` boolean, which is the default
visibility rule for all contacts at that company (most companies leave
this off — a PM sees all company projects — but a company can request
it be turned on). `contacts.can_view_all_company_projects` (nullable
bool) allows a per-contact override in either direction.

**Roles and permissions for staff use `spatie/laravel-permission`**,
attached to the `Employee` model via its `HasRoles` trait (not to
`User` directly — permissions are a staff-only concept). This was
chosen over a hand-rolled `roles` + pivot table because:

- Employees can legitimately hold multiple roles at once (a real
  example: an employee who is both Office Admin and PLS), which
  spatie's `model_has_roles` many-to-many pivot supports natively.
- PLS is a licensed role with real regulatory sign-off authority
  (e.g. plat approval) that will need fine-grained permissions
  distinct from role name, sooner or later. spatie lets that be a
  data change (new permission row, assign to role) instead of a
  migration.
- A future in-app "portal admin" screen for managing roles/permissions
  can be built directly on spatie's existing tables rather than a
  custom authorization engine.

PLS-specific regulatory permissions are **not** being modeled in v1 —
noted here so the reasoning isn't lost, but deferred intentionally to
keep the initial migration set small.

## Portal access control (contacts)

A `users` row is created **automatically** when a `contacts` row is
created, with `password` left `NULL`. This keeps `contacts.user_id`
always populated (no nullable-relationship checks scattered through
the app) without granting any access yet — a null password hash fails
`Hash::check` by default.

The actual access gate is `contacts.portal_enabled` (boolean, default
`false`), toggled by staff. It is checked inside a custom
`Fortify::authenticateUsing()` closure alongside the password check,
so disabling a contact's access takes effect immediately and isn't
scattered across controllers.

The first time `portal_enabled` is flipped to `true`, that's the
trigger to send a "set your password" email, reusing Laravel's
built-in password-reset broker as an invite mechanism (it only
requires an existing `users` row + email, not an existing password).

## Name and email — single source of truth

`contacts` does **not** duplicate `name` or `email` from `users`.
Every contact has a `users` row by design (see above), so
`users.name` is the canonical name (`$contact->user->name`) and
`users.email` is the canonical **login** email.

The one legitimate reason to diverge is correspondence: a contact may
want project notifications and invoices sent somewhere other than
their login address (e.g. logging in with a personal email but
wanting billing sent to `accounting@company.com`). That case is
handled by a single nullable column, `contacts.notification_email`,
not a duplicate of the login email. The `Contact` model exposes an
`effective_notification_email` accessor that returns
`notification_email` if set, else falls back to `user->email` — every
mailer/notification class calls that accessor and never has to
null-check directly. If `notification_email` is left null and the
contact's login email changes later, the "effective" address follows
automatically, which is the intended behavior (an unset
`notification_email` means "same as login," on an ongoing basis, not
a one-time copy).

## Self-service profile editing is disabled globally

Fortify's `Features::updateProfileInformation()` is turned **off** in
`config/fortify.php` for all users — employees and contacts alike.
Name and email changes go through staff (the same admin screens used
to manage every other part of a contact/employee record), not through
a self-service form.

This was a deliberate choice over building a custom
`Fortify::updateUserProfileInformationUsing()` action scoped to
employees only. A scoped action was considered (see Alternatives)
but rejected as unnecessary complexity for a team this size — the
cost of "staff occasionally edits someone's email for them" is
trivial at 4-5 employees, and a global toggle needs zero custom code
to write or maintain.

`Features::updatePasswords()` (changing your own password while
logged in) is **not** affected by this and remains on for everyone —
it carries none of the same "silently change how I'm identified"
risk that an email change does.

One consequence to handle: if a contact has a pending invite
(`portal_enabled` just turned on, reset-link sent, password not yet
set) and staff then edit that contact's email before they've logged
in, the original invite link was generated for the old address. The
update-contact code path should detect a pending invite and
re-trigger the invite email automatically rather than leave a dead
link outstanding.

## Alternatives considered

- **Single `users` table with a `type` discriminator and no separate
  profile tables** — rejected: staff and client data are different
  enough (permissions vs. company/project-visibility flags) that one
  table would accumulate a lot of nullable, type-specific columns.
- **Fully separate Authenticatable models + auth guards for staff vs.
  contacts** — closest to what the legacy tooling had drifted toward.
  Rejected in favor of a single guard + `users.type` because it's
  simpler to configure with Fortify out of the box and we don't
  currently need guard-level session/cookie separation.
- **A dedicated "individuals" table separate from company contacts** —
  rejected: `contacts.company_id` nullable achieves the same result
  with one table instead of two, and keeps the portal / project-access
  code path identical for both cases.
- **A custom `UpdatesUserProfileInformation` action, scoped to allow
  self-service edits for employees but block them for contacts** —
  considered as a way to get self-service editing for staff without
  opening it up to contacts. Rejected: at 4-5 employees, the admin
  overhead of staff editing their own name/email for them is
  negligible, and it avoids writing and maintaining custom code for a
  Fortify extension point most teams never need to touch.

## Consequences

- Every table that needs "who did this" can FK to `users.id` uniformly
  regardless of whether the actor is staff or a client.
- Adding a new staff permission is a data change, not a schema change.
- `contacts.company_id IS NULL` becomes the standard, documented way
  to query "individual clients" — should be called out in code
  comments and in the Contact model, since it's not obvious from the
  schema alone.
- Company-level project-visibility restriction still needs its
  supporting pivot table (`contact_project_access` or similar) —
  covered in a follow-up ADR once we design the projects/access slice.
- Self-service profile editing being globally off means any future
  "let clients manage their own contact info" request is additive
  (a new, deliberately-scoped feature) rather than a reversal of this
  decision.

## Amendment log

- **2026-07-12:** Removed `contacts.full_name`/`contacts.email` from
  the original draft of this ADR (they were carried over from the
  legacy `client_company_contacts` table without being re-justified
  for a design where every contact has a `users` row). Replaced with
  the "Name and email — single source of truth" section, and added
  `contacts.notification_email`. Added the "Self-service profile
  editing is disabled globally" decision.
