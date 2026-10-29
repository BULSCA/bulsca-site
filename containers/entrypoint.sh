#!/bin/sh
set -eu
if [ -z "${APP_KEY:-}" ] || [ "${APP_ENV:-}" != production ] || [ "${APP_DEBUG:-false}" != false ]; then
    echo 'Production requires the existing APP_KEY, APP_ENV=production and APP_DEBUG=false.' >&2
    exit 1
fi
mkdir -p storage/app/public storage/app/private storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
# Configuration is generated per container after deployment secrets are supplied.
php artisan config:cache --quiet
exec "$@"
