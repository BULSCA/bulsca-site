# Working on the shared BULSCA backend

## Scope and release workflow

- This repository is `BULSCA/bulsca-site`, the authoritative Laravel backend. Sibling `../admin-panel` contains the standalone Vue member portal; `../bulsca-frontend` contains the public Vue website.
- Use `CODEX/` feature branches and PRs into `release/public-site-v1`. Only release branches omit that prefix. Keep focused commits; do not merge, force-push or delete branches without explicit instructions.
- The owner prohibits application/asset builds, container image builds and deployment. Tests, lint, type checks and development servers are permitted. Production migrations, initial user grants and deployment verification belong to the owner.
- Preserve the existing public API contracts, legacy portal and stored data. Do not replace the retained authentication protocol or import old administrators as new privileges without an explicit migration plan.

## Organisation portal: start here

Read the README's "Organisation portal API" section. Backend branch `CODEX/organisation-memberships` pairs with portal branch `CODEX/organisation-portal`.

| Concern | Source |
| --- | --- |
| Additive schema and tenant foreign keys | `database/migrations/2026_10_29_180000_create_portal_organisations.php` |
| Domain models | `app/Models/Portal/` (separate from existing public committee models) |
| Authorisation and permission catalogue | `app/Services/PortalAccess.php` |
| Private API and session routes | `app/Http/Controllers/Api/V1/PortalController.php`, `routes/portal.php` |
| Existing SSO protocol and secure session handling | `app/Http/Controllers/Auth/SSOAuthController.php` |
| Explicit initial grant and audit retention | `app/Console/Commands/BootstrapPortal.php`, `PrunePortalAudit.php` |
| Public club logo override | `PeopleController.php`, `University::portalOrganisation()` |
| Feature/security tests | `tests/Feature/Api/PortalTest.php`, `PortalAuthenticationTest.php`, `PublicBrowsingTest.php` |

## Security and domain invariants

- A person may belong to several organisations. A club's parent is BULSCA; affiliation is separate from individual membership.
- Membership alone grants no management. Permissions come from active, unrevoked appointments during inclusive committee dates in Europe/London. Global root remains Spatie's existing `super_admin` role.
- Club roles may grant only the club catalogue. Only an explicit BULSCA `clubs.manage` appointment grants authority over affiliated clubs. Actors may delegate only permissions they already hold in that organisation.
- Keep every write authorised server-side, tenant-scoped and transactional. Preserve composite foreign keys, immediate revocation and last-current-manager protection. Reactivating membership does not restore old appointments.
- The protected Organisation manager role cannot be edited. Preserve role/appointment history. Do not allow browser requests to grant global roles or invoke the bootstrap command.
- Private reads/writes use the web session, CSRF, JSON responses and `private, no-store`; outsiders receive 404. Member email addresses require `members.manage`.
- Never log SSO codes, tokens, provider bodies, exception messages or submitted forms. Diagnostics use safe categories/templates; administration audits store limited IDs/action metadata and are pruned after 90 days.
- Logo storage failure must retain the previous database branding. Validate image type/size/dimensions, reject SVG and arbitrary CSS, and delete previous files only after commit.

## Verification and handover

PHP 8.3 and MySQL 8.4 are exercised in CI. Install development dependencies and run `vendor/bin/phpunit` against a separate LOCAL MySQL database ending in `_test`, with `APP_ENV=testing` and no `DB_URL`. See `tests/Support/TestDatabaseGuard.php` before configuring it. Tests migrate/reset that database; never reuse the application database or disable the guard. CI also checks PHP syntax, existing public API browser integration and container configuration, without asset/image builds or deployment.

Before the wrap-up, the full local suite passed 109 tests; a later regression test verifies that explicit bootstrap restores a revoked initial appointment. Fresh GitHub CI is the source of truth for the final commits. PHP tooling installed under `/tmp` in the earlier session was temporary; do not assume it exists. Use installed PHP or CI rather than weakening tests to fit an absent runtime.

The new portal's complete browser flow against this API and real SSO still needs acceptance. The current release container continues to serve legacy portal pages; the standalone Vue cutover and production onboarding are separate owner-run steps. Existing public biographies/administrators are not automatically migrated. Account invitations/provisioning and new competition/content editing permissions are not implemented. Use focused follow-up work rather than an architectural rewrite.
