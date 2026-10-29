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

`.github/workflows/api-tests.yml` runs Composer validation/install, PHP syntax and the full PHPUnit suite on PHP 8.3 with an isolated MySQL 8 service. `Required CI` fails when a prerequisite fails, is cancelled or is skipped. JUnit results are retained for seven days. PR creation/updates/drafts/retargeting, default/release pushes and merge queues are covered.

For local tests, use `phpunit.xml` with a dedicated local MySQL database ending in `_test`, `APP_ENV=testing`, `DB_URL` empty and test-only credentials. The guard rejects nonlocal hosts, unsafe database names and a database matching the application `.env` before migrations run. Run `composer validate --strict --no-check-publish`, `composer install` and `vendor/bin/phpunit`; CI syntax checks cover app/tests/database/routes/config. Never supply application database credentials to the test command.

GitHub rulesets require PRs and an up-to-date `Required CI` from GitHub Actions on the default branch and `release/` branches (including nested release names), with no bypass actors or mandatory human approvals. Force pushes and deletion are blocked. These settings live in GitHub, independently of workflow files. Existing PRs without the workflow need updating before merge. CODEX development branches remain pushable. No assets/containers are built and nothing is deployed by these checks.

## Public website API and launch handover

The public Vue site now consumes `/api/v1` for clubs/committee profiles, competition calendars/details, archived championship years, A/B/historical overall standings, resource categories/search/downloads, SERCs/casualties, homepage presentation/notices/social updates, contact submissions and article interactions. `docs/api/openapi.json` owns the wire contract. `tools/generate_api_types.py` generates the public frontend types; use `--check` to detect drift. Public responses expose allowlisted fields. Rich content is sanitized with the same allowlist as articles. GET requests do not create competition info or increment content counters.

Resources remain on the existing filesystem. Only resources linked from published pages, SERCs, competitions or archived championship content are listed/accessed by the new API. Access returns an absolute download URL; storage paths never reach the browser. File delivery uses an attachment response with nosniff. Historical `/resources/view/{id}` links remain available. `resources/data/championships.json` preserves the published archival text/links; additional years can be added without another Blade route. `config/public_site.php` holds presentation/campaign settings and preserves the published Champs 2027 announcement. Existing global-banner administration is exposed through `/notice`. Existing league calculations and their administration remain authoritative.

For contact submissions configure `TURNSTILE_SITE_KEY`, `TURNSTILE_SECRET_KEY` and the existing mail transport/from address. `CONTACT_FORM_ENABLED=false` disables online submissions while leaving department email links available. Captcha verification and email are never performed by the browser. Failed/uncertain sends are not retried automatically. Configure a writable non-database `PUBLIC_API_CACHE_STORE` (file by default) for interaction deduplication and cached social updates. Social provider failures retain marked cached results for up to 24 hours, back off for a minute and log safe context. Article view/rating events use UUID event IDs, 24-hour deduplication and atomic counters without changing publication timestamps. Contact, view and rating rate limits use separate buckets.

Deployment checks belong to the owner: land the paired PR stack and required CI first, preserve the existing database/files/admin URLs, set correct `APP_URL`/trusted proxy configuration and keep debug output disabled. Configure the frontend's `VITE_PORTAL_URL` to the existing Laravel administration origin; the new portal/authentication migration is deferred. Proxy `/api`, `/storage` and `/img` as appropriate, or configure a public backend origin with CORS. Verify real records/archives, media, PDF downloads, captcha/mail delivery and management links. Current privacy/cookie/terms gaps require owner-approved text; none has been invented. No builds, production migrations, file migration or cutover are included in this work.

### Real API integration checks

The frontend's `scripts/ci-api-integration.sh` starts a Vue dev server, Chrome and Laravel against seeded isolated SQL data. `tests/Support/public-api-bootstrap.php` refuses unsafe environments/databases before seed/reset or HTTP handling, uses temporary cache/files, and fakes external HTTP/mail. The test-only router can inject an actual Laravel failure; no fault injection exists in product routes. The suite checks public pages at six widths, real downloads/contact/ratings, safe failures and recovery. Each repository's CI tests its PR against a pinned counterpart commit; update that reference when coordinating contract changes. Browser reports/screenshots, safe diagnostics and server logs are retained as CI artifacts. Nothing is built or deployed.
