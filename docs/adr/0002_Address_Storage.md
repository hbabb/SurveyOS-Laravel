# ADR 0002: Address Storage on Companies and Contacts

## Status
Accepted

## Context

Both `companies` and `contacts` need address data:

- **Companies** need a required billing address (where invoices go) and an
  optional physical address (their office, if different from billing).
- **Contacts** representing individuals (`company_id IS NULL`) need a single
  address that functions as their billing address, since there is no
  company row to hold one on their behalf. This follows the same pattern
  established in ADR 0001 — individuals are first-class rows in `contacts`,
  not a separate table.

Two structural options were considered for storing this data.

## Decision

**Option A — inline columns on both tables** was chosen.

`companies` gets two prefixed sets of address columns:

```php
// companies
$table->string('billing_address_line_1');
$table->string('billing_address_line_2')->nullable();
$table->string('billing_city');
$table->string('billing_state_province');
$table->string('billing_postal_code');
$table->string('billing_country');

$table->string('physical_address_line_1')->nullable();
$table->string('physical_address_line_2')->nullable();
$table->string('physical_city')->nullable();
$table->string('physical_state_province')->nullable();
$table->string('physical_postal_code')->nullable();
$table->string('physical_country')->nullable();
```

`contacts` gets one unprefixed set (serves as the individual's billing
address; only meaningful when `company_id IS NULL`):

```php
// contacts
$table->string('address_line_1')->nullable();
$table->string('address_line_2')->nullable();
$table->string('city')->nullable();
$table->string('state_province')->nullable();
$table->string('postal_code')->nullable();
$table->string('country')->nullable();
```

Billing address fields on `companies` are required (not nullable); physical
address fields are nullable. Contact address fields are nullable, since
they're only populated for individuals.

### Why

- No joins — a company or contact row carries everything needed in one
  read. Simplest to query, simplest to reason about as a solo developer.
- This is a small survey firm's internal CRM, not a multi-tenant SaaS.
  There's no current requirement for address history, multiple physical
  addresses per company, or new address "types" beyond billing/physical.
- The cost of being wrong is low: this can be migrated to Option B later
  as a data migration if requirements grow into it (see below).

### Format validation

Column structure (city, state/province, postal code, country as separate
fields) lives in the schema. Format rules — e.g., valid postal code shape
per country, whether state/province is required for a given country — are
**not** enforced at the DB level. They belong in application code, via a
Form Request or a dedicated `Address` validation rule, since "postal code
format depends on country" isn't something a DB constraint can reasonably
express.

## Option Considered — Polymorphic `addresses` Table

Not chosen now, but documented here so a future revisit has a single
source of truth for the reasoning and the shape, rather than reinventing
the design from scratch.

```php
Schema::create('addresses', function (Blueprint $table) {
    $table->id();
    $table->morphs('addressable'); // addressable_type, addressable_id
    $table->enum('type', ['billing', 'physical']);
    $table->string('address_line_1');
    $table->string('address_line_2')->nullable();
    $table->string('city');
    $table->string('state_province');
    $table->string('postal_code');
    $table->string('country');
    $table->timestamps();

    $table->unique(['addressable_type', 'addressable_id', 'type']);
});
```

Both `Company` and `Contact` models would get a `morphMany(Address::class,
'addressable')` (or `morphOne` per type, enforced by the unique
constraint). This mirrors the polymorphic pattern already used by
spatie/laravel-permission's `model_has_roles` table elsewhere in this
schema — not a new concept for the codebase if adopted later.

### Tradeoffs vs. Option A

| | Option A (inline) | Option B (polymorphic table) |
|---|---|---|
| Query simplicity | Plain column read | Requires join / eager load |
| Schema duplication | Address shape repeated 3x (company billing, company physical, contact) | Defined once, reused everywhere |
| Adding a new address type later | New migration + new column set | Data change only — no migration |
| Multiple addresses of the same type per entity | Not supported without further migration | Supported (drop the unique constraint) |
| Complexity for a solo dev / small app | Low | Moderate (morph relations, eager-loading discipline to avoid N+1) |

### Migration path if revisited

If a future need arises (address history, multiple physical locations,
a new address type), the move from A to B is a data migration:
1. Create the `addresses` table.
2. For each `companies`/`contacts` row, insert one or two `addresses` rows
   from the existing prefixed columns.
3. Drop the old columns once the application code is switched to the
   morph relations.

This is mechanical, not a redesign — the column shape carries over
directly into the new table's rows.

## Addendum: US-Only Scoping (added after initial migration)

While writing the actual `companies` migration, the address fields were
further scoped to **US-only, for now**:

- No `country` column on either table.
- `billing_state`/`physical_state` (companies) and `state` (contacts) are
  `varchar(2)`, holding a USPS state abbreviation rather than a free-form
  string.
- `state_province` and `postal_code` were renamed to `state` and `zip`
  respectively, matching the terminology the team actually uses day to
  day, rather than the more internationally-neutral names originally
  drafted above.

This is a deliberate simplification, not an oversight — the firm
currently operates U.S.-only, and there's no present need to support
international address formats. It is expected to be revisited when a
Java-based V2/V3 of the application is built, at which point
international clients may become a realistic possibility and `country`
(along with a less US-specific `state`/`zip` shape) should be
reintroduced if so.

## Consequences

- `companies` and `contacts` migrations will each carry their own set of
  address columns rather than referencing a shared table.
- Address format validation is an application-layer concern (Form
  Requests / rule objects), not a database-layer one.
- If growth requires it, Option B is available as a documented,
  non-speculative upgrade path — see above.
