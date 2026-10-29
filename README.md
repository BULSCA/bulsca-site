<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Backend pull request checks

`.github/workflows/api-tests.yml` runs Composer validation/install, PHP syntax and the full PHPUnit suite on PHP 8.3 with isolated MySQL 8.4 services. `Required CI` also requires public API integration and container configuration checks, and fails when a prerequisite fails, is cancelled or is skipped. JUnit results are retained for seven days. PR creation/updates/drafts/retargeting, default/release pushes and merge queues are covered.

For local tests, use `phpunit.xml` with a dedicated local MySQL database ending in `_test`, `APP_ENV=testing`, `DB_URL` empty and test-only credentials. The guard rejects nonlocal hosts, unsafe database names and a database matching the application `.env` before migrations run. Run `composer validate --strict --no-check-publish`, `composer install` and `vendor/bin/phpunit`; CI syntax checks cover app/tests/database/routes/config. Never supply application database credentials to the test command.

GitHub rulesets require PRs and an up-to-date `Required CI` from GitHub Actions on the default branch and `release/` branches (including nested release names), with no bypass actors or mandatory human approvals. Force pushes and deletion are blocked. These settings live in GitHub, independently of workflow files. Existing PRs without the workflow need updating before merge. CODEX development branches remain pushable. No assets/containers are built and nothing is deployed by these checks.

## Public website API and launch handover

The public Vue site now consumes `/api/v1` for clubs/committee profiles, competition calendars/details, archived championship years, A/B/historical overall standings, resource categories/search/downloads, SERCs/casualties, homepage presentation/notices/social updates, contact submissions and article interactions. `docs/api/openapi.json` owns the wire contract. `tools/generate_api_types.py` generates the public frontend types; use `--check` to detect drift. Public responses expose allowlisted fields. Rich content is sanitized with the same allowlist as articles. GET requests do not create competition info or increment content counters.

Resources remain on the existing filesystem. Only resources linked from published pages, SERCs, competitions or archived championship content are listed/accessed by the new API. Access returns an absolute download URL; storage paths never reach the browser. File delivery uses an attachment response with nosniff. Historical `/resources/view/{id}` links remain available. `resources/data/championships.json` preserves the published archival text/links; additional years can be added without another Blade route. `config/public_site.php` holds presentation/campaign settings and preserves the published Champs 2027 announcement. Existing global-banner administration is exposed through `/notice`. Existing league calculations and their administration remain authoritative.

For contact submissions configure `TURNSTILE_SITE_KEY`, `TURNSTILE_SECRET_KEY` and the existing mail transport/from address. `CONTACT_FORM_ENABLED=false` disables online submissions while leaving department email links available. Captcha verification and email are never performed by the browser. Failed/uncertain sends are not retried automatically. Configure a writable non-database `PUBLIC_API_CACHE_STORE` (file by default) for interaction deduplication and cached social updates. Social provider failures retain marked cached results for up to 24 hours, back off for a minute and log safe context. Article view/rating events use UUID event IDs, 24-hour deduplication and atomic counters without changing publication timestamps. Contact, view and rating rate limits use separate buckets.

Deployment checks belong to the owner. The paired `release/public-site-v1` branches contain the previous implementation stacks; review container work through `CODEX/` PRs targeting those releases. Default branches remain unchanged and nothing is merged automatically. The new portal/authentication migration is deferred. Verify real records/archives, media, PDF downloads, captcha/mail delivery and management links. Current privacy/cookie/terms gaps require owner-approved text; none has been invented. Builds, production migrations, database/file transfers and cutover are operator actions described below.

### Real API integration checks

The frontend's `scripts/ci-api-integration.sh` starts a Vue dev server, Chrome and Laravel against seeded isolated SQL data. `tests/Support/public-api-bootstrap.php` refuses unsafe environments/databases before seed/reset or HTTP handling, uses temporary cache/files, and fakes external HTTP/mail. The test-only router can inject an actual Laravel failure; no fault injection exists in product routes. The suite checks public pages at six widths, real downloads/contact/ratings, safe failures and recovery. Each repository's CI tests its PR against a pinned counterpart commit; update that reference when coordinating contract changes. Browser reports/screenshots, safe diagnostics and server logs are retained as CI artifacts. Nothing is built or deployed.

## Podman release deployment (operator-run)

Use sibling `bulsca-site` and `bulsca-frontend` checkouts of the reviewed release commits on a Linux host with rootless Podman 5+, `podman-compose` 1.5.0 and an existing HTTPS reverse proxy. `release/public-site-v1` is the target in both repositories; only release branches omit the `CODEX/` prefix. Review the focused commits in each implementation PR and merge them into the releases yourself. Neither default branch is a release target.

`Containerfile` has `runtime` (PHP 8.3) and `web` (unprivileged Nginx) targets. Compose adds the compiled Vue frontend, MySQL 8.4 and one Laravel scheduler. Backend/web images must use the same backend commit. The application account is distinct from database root. Compose publishes only `127.0.0.1:8080` (Vue) and `127.0.0.1:8081` (backend web); PHP and MySQL remain on the container network. The frontend can serve its shell while the backend is unavailable, without retrying proxied writes.

### Configuration and images

Copy `containers/release.env.example` to `.env.release`, set mode 600, and fill in the two exact Git commits as image tags plus your credentials. Preserve the existing `APP_KEY`. Single-quote values containing `$`, `#` or spaces in this dotenv file. Never commit it or save expanded `compose config` output containing production secrets. `containers/compose.sh` selects the Podman Compose provider and this env file; `RELEASE_ENV_FILE` can select a separate staging configuration.

`APP_URL` is the portal origin; `PUBLIC_API_URL` is the API origin. Sessions are host-scoped, secure, HttpOnly and SameSite=Lax. Register `https://portal.bulsca.co.uk/auth/sso/callback` with the current identity provider. Configure Turnstile for the website hostname and SMTP before enabling contact submissions. Test with `CONTACT_FORM_ENABLED=true` on staging first; the example leaves production submissions disabled until accepted. Social integration is optional. Its initial token comes from the environment; weekly refresh stores subsequent tokens encrypted under `storage/app/private/meta-token.enc`. Both readers and the scheduler use this file, and refresh failures retain the previous token. Replacing an expired/corrupt token requires stopping the scheduler, setting a fresh initial token and removing the old encrypted token file before restarting. Never publish or serve this private directory.

The following commands build images and are for the owner to run later:

```sh
containers/compose.sh build frontend backend backend-web
containers/compose.sh pull database
```

Vite values are fixed during the frontend image build. The image always uses live data, relative `/api/v1` consumers and the configured portal origin. Rebuild it when those settings change. No `.env`, uploaded files, local dependencies, test seeders or fault-injection routers are copied into production images. Runtime startup regenerates configuration using supplied secrets; it never generates keys, migrates or seeds a database.

### Existing data and MySQL 8.4 rehearsal

Before moving data, record the source engine/version (`SELECT VERSION()`), pending migrations, table engines, database size and uploaded-file locations. Export the application database only, including routines/triggers/events, using a source-compatible logical dump tool. Retain the existing database and a verified off-host backup. Do not mount its physical data directory into MySQL 8.4 or import database system users. Follow the [supported MySQL upgrade path](https://dev.mysql.com/doc/refman/8.4/en/upgrade-paths.html); older MySQL versions may need intermediate upgrades, and MariaDB exports require a separately verified compatibility rehearsal.

Use fresh named volumes for the rehearsal. The defaults below must match `.env.release`; staging should use different volume/project names, loopback ports, hostnames and network subnet. Update `TRUSTED_PROXIES` to match that subnet and the actual proxy peer addresses.

```sh
podman volume create bulsca-mysql-v1
podman volume create bulsca-storage-v1
containers/compose.sh up -d --no-build database
containers/restore-db.sh /secure/path/source-application.sql.gz --confirm-empty-database
```

Restore refuses a nonempty target database and stops on SQL errors. A failed partial import requires another fresh volume. Keep application writers stopped during restoration. Compare table counts, representative row counts, relationships, league calculations and pending migrations with the source before continuing. Rehearse imports and any required migrations on a copy first; run `containers/compose.sh run --rm --no-deps backend php artisan migrate --force` only as an explicit reviewed deployment step. Never use `migrate:fresh` for a release database.

Create an archive of the **contents** of the old Laravel `storage` directory (including hidden files and all `app` files) and import it into the fresh storage volume with `podman volume import bulsca-storage-v1 /secure/path/storage.tar`. Align the final SQL/files snapshot while old application writers are stopped. Set ownership on this copied volume only:

```sh
containers/compose.sh run --rm --no-deps --user 0 --entrypoint chown backend -R 33:33 /var/www/html/storage
containers/compose.sh up -d --no-build
```

PHP and the scheduler mount writable shared storage; the web container mounts it read-only and exposes only `storage/app/public`. Named volumes use Podman's labeling; do not relabel or recursively chown the live source tree. External volumes survive Compose teardown. Back them up independently of images. `containers/backup-db.sh /secure/path/release.sql.gz` creates a compressed, mode-600 application dump, refuses existing destinations and removes partial output on failure. Also back up storage consistently, the existing key and the deployment configuration. Rehearse restoring these backups, not just creating them.

### HTTPS proxy and acceptance

Route `www.bulsca.co.uk` to loopback 8080 and both `api.bulsca.co.uk` and `portal.bulsca.co.uk` to loopback 8081. Preserve the hostname and overwrite client-supplied forwarding headers with the real client address, canonical host and HTTPS scheme. Keep the application ports bound to loopback. The internal web proxy forwards these headers through the configured trusted proxy chain; check real client IPs so visitors do not share one rate-limit bucket. Allow uploads up to 34 MiB through the host proxy. The API hostname serves public API/media/download routes; portal login and management routes are handled only at the portal hostname.

`/health/live` checks application boot without database/cache dependencies. `/health/ready` checks SQL connectivity, writable runtime paths and cache read/write, returning only `ok` or a safe `503 unavailable`. `/health/web` checks Nginx itself. Vue's `/health/live` stays healthy during backend outages. Health endpoints never call mail, captcha or social providers.

With Node 24 available, run the read-only acceptance tool after deployment:

```sh
PUBLIC_SITE_ORIGIN=https://www.bulsca.co.uk \
PUBLIC_API_ORIGIN=https://api.bulsca.co.uk \
PORTAL_ORIGIN=https://portal.bulsca.co.uk \
node tools/smoke_release.mjs
```

It verifies deep-link/static serving, missing assets, same-origin and direct API requests, readiness, portal routing and a real published document download. Empty resource lists explicitly report a skipped download check and require manual coverage. Manually check existing images, championship archives, real SSO/session/logout, representative management edits, league tables and captcha/mail delivery. Verify graceful public pages and server diagnostics during a staging backend/database outage, recovery, container replacement and a host reboot. Missing approved privacy/cookie/terms text remains a launch content gap.

### Reboot recovery and rollback

Adapt the checkout location in `containers/bulsca.service`, install it as a user systemd unit, enable it with `systemctl --user enable --now bulsca.service` and enable lingering for the deployment user. The service starts already-built images and stops containers without deleting volumes. Check `containers/compose.sh ps`, `containers/compose.sh logs --tail=100` and `systemctl --user status bulsca.service` during the reboot rehearsal. Diagnostics persist under `storage/logs`; PHP/Nginx process errors also appear in container logs.

Record the exact frontend/backend commits, resulting image IDs/digests (including the MySQL image), configuration identifier, source/target DB versions, backup locations and acceptance results before declaring the candidate ready. Keep previous images and configuration. Freeze writes for final data transfer/cutover and confirm acceptance before reopening them. To roll back application images, restore the previous paired tags/configuration and recreate services with `up -d --no-build`; verify health and smoke checks. Database/schema rollback requires the rehearsed backup and matching files/key, not an image downgrade on the new data directory. Once new writes are accepted, reconcile them before switching to an old database.

### Configuration checks without builds

`bash containers/check.sh` requires the sibling frontend, Node 24, Python/PyYAML, `podman-compose` 1.5.0, Podman, Nginx and ShellCheck. It verifies a checksum-pinned Hadolint binary, shell scripts, Compose normalization with fake secrets, real Nginx routing against temporary fixtures/fake FastCGI, and smoke-tool tests. CI runs these as `Container configuration`, required by `Required CI` in both repositories. No containers are started and no assets or images are built by these checks. Built-image and deployment verification remain owner-run gates.
