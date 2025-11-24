FROM composer:2 AS composer-binary

FROM php:8.4-cli-alpine AS composer-builder
WORKDIR /app
COPY --from=composer-binary /usr/bin/composer /usr/bin/composer
RUN apk add --no-cache icu-dev git zip unzip libzip-dev zlib-dev \
	&& docker-php-ext-configure zip \
	&& docker-php-ext-install intl exif zip
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts
COPY . /app
RUN composer dump-autoload --optimize --no-interaction
RUN cp vendor/laravel/octane/src/Commands/stubs/frankenphp-worker.php public/frankenphp-worker.php

FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json pnpm-lock.yaml ./
RUN corepack enable && pnpm install --frozen-lockfile

COPY --from=composer-builder /app /app

RUN pnpm run build

FROM dunglas/frankenphp:1-php8.4

WORKDIR /app

COPY --from=node-builder /app /app

RUN install-php-extensions bcmath intl pcntl pdo_mysql redis opcache zip exif

RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

ENV APP_ENV=production \
	APP_DEBUG=false \
	APP_BASE_PATH=/app \
	APP_PUBLIC_PATH=/app/public \
	CADDY_SERVER_SERVER_NAME=":8000" \
	CADDY_SERVER_ADMIN_HOST=127.0.0.1 \
	CADDY_SERVER_ADMIN_PORT=2019 \
	CADDY_SERVER_LOG_LEVEL=INFO \
	CADDY_SERVER_LOGGER=json \
	CADDY_GLOBAL_OPTIONS="auto_https disable_redirects"

ENTRYPOINT ["frankenphp", "run", "-c", "/app/vendor/laravel/octane/src/Commands/stubs/Caddyfile"]

EXPOSE 8000
