FROM composer:2 AS composer-binary

FROM php:8.4-cli-alpine AS composer-builder
WORKDIR /app
COPY --from=composer-binary /usr/bin/composer /usr/bin/composer
RUN apk add --no-cache icu-dev git zip unzip libzip-dev zlib-dev \
	&& docker-php-ext-configure zip \
	&& docker-php-ext-install intl exif zip
COPY . /app
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

FROM node:20-alpine AS node-builder

WORKDIR /app

COPY --from=composer-builder /app /app

RUN corepack enable && pnpm install --frozen-lockfile

RUN pnpm run build

FROM dunglas/frankenphp:1-php8.4

WORKDIR /app

COPY --from=node-builder /app /app

RUN install-php-extensions bcmath intl pcntl pdo_mysql redis opcache zip exif

RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

ENTRYPOINT ["frankenphp", "php-cli", "artisan", "octane:frankenphp"]

EXPOSE 8000
