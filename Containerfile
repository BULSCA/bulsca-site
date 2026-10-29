FROM docker.io/library/php:8.3-fpm-bookworm AS php-base
# Distribution packages receive security updates from the versioned base distro.
# hadolint ignore=DL3008
RUN apt-get update \
    && apt-get install -y --no-install-recommends libfreetype6-dev libjpeg62-turbo-dev libpng-dev libonig-dev libicu-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring gd intl zip calendar opcache bcmath \
    && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html
ENV APP_ENV=production APP_DEBUG=false
COPY containers/php.ini /usr/local/etc/php/conf.d/zz-bulsca.ini

FROM php-base AS dependencies
COPY --from=docker.io/library/composer:2 /usr/bin/composer /usr/local/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --no-scripts --no-autoloader
COPY . .
RUN mkdir -p bootstrap/cache storage/app/public storage/app/private storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && composer dump-autoload --no-dev --classmap-authoritative --no-scripts \
    && php artisan package:discover --ansi \
    && ln -s /var/www/html/storage/app/public public/storage

FROM php-base AS runtime
COPY --from=dependencies --chown=33:33 /var/www/html /var/www/html
COPY --chmod=0555 containers/entrypoint.sh /usr/local/bin/bulsca-entrypoint
USER 33:33
EXPOSE 9000
ENTRYPOINT ["bulsca-entrypoint"]
CMD ["php-fpm", "-F"]
HEALTHCHECK --interval=30s --timeout=5s --start-period=30s --retries=3 \
    CMD ["php", "containers/healthcheck.php"]

FROM docker.io/nginxinc/nginx-unprivileged:1.28-alpine AS web
ENV PUBLIC_API_HOST=api.bulsca.co.uk PORTAL_HOST=portal.bulsca.co.uk \
    NGINX_ENVSUBST_FILTER="PUBLIC_API_HOST|PORTAL_HOST|NGINX_RESOLVERS"
COPY --chmod=0555 containers/10-resolvers.envsh /docker-entrypoint.d/10-resolvers.envsh
COPY containers/default.conf.template /etc/nginx/templates/default.conf.template
COPY --from=dependencies /var/www/html/public/ /var/www/html/public/
USER 101
EXPOSE 8080
HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD ["wget", "-q", "-O", "/dev/null", "--header=Host: api.bulsca.co.uk", "http://127.0.0.1:8080/health/web"]
