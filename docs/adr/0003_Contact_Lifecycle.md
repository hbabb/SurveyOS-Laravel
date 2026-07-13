# ADR 0003: Contact Lifecycle (Deferred Per-Contact Status Override)

## Status
Accepted (with an explicit deferral noted for a future version)

## Context

`account_status` was added to both `companies` and `contacts` (nullable on
`contacts`, since an individual has no company row to inherit status from).

This raised a related question: when a contact leaves a company — is let
go, changes roles, or otherwise should no longer be treated as an active
point of contact — does the system need a way to mark *that specific
contact* as inactive independently of the company's own `account_status`?

Example: Acme Surveying is an active client, but Jane Doe (a contact at
Acme) leaves the company. The company is still active; Jane individually
should no longer be contacted.

## Decision

For the current version of the application, **this scenario is handled by
deleting the outgoing contact's row and creating a new contact row** for
their replacement, rather than building a status-override or contact
history mechanism.

### Why

- The application currently serves a single internal survey firm. There is
  no near-term need to preserve a record of former contacts, audit who was
  a contact at what time, or reason about contact status independently of
  company status.
- Building override/history logic (e.g., a `contact_status` distinct from
  and capable of superseding `account_status`, or soft-deletes with
  historical tracking) is real design and implementation work with no
  current use case to justify it.
- Simplicity now is a deliberate trade, not an oversight — see below for
  when it stops being the right trade.

## Consequences

- No `contact_status` field, override mechanism, or contact history table
  exists in the current schema. `account_status` on `contacts` continues
  to represent status for individuals only (`company_id IS NULL`);
  company-affiliated contacts have no independent status of their own.
- Deleting and recreating contacts means historical context about a former
  contact (who they were, when they left, why) is lost once deleted. This
  is acceptable for the current internal-use case but should be
  re-evaluated before it becomes a problem in practice.

## Future Revisit

This decision is explicitly expected to be revisited for a "V3" version of
the application, at the point where this app is packaged as a product to
be sold to other land survey firms rather than run internally. Multi-firm
customers are far more likely to need:

- A record of former contacts (who left, when, why) for their own
  business/audit purposes.
- Per-contact status independent of company status, without losing
  history by deleting rows.

When that work begins, this ADR should be superseded by one that designs
either a `contact_status` override field, soft-deletes with an
`ended_at`/reason field, or a proper contact-history table — informed by
whatever real customer requirements exist at that time rather than
speculative design now.
