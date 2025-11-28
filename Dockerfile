FROM php:8.4-cli-alpine AS composer-builder

WORKDIR /app

RUN apk add --no-cache icu-dev libzip-dev libexif-dev g++ make autoconf libc-dev pkgconf

RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl zip exif

RUN apk del g++ make autoconf libc-dev pkgconf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

COPY . /app
RUN composer dump-autoload --optimize


FROM node:20-alpine AS node-builder

WORKDIR /app

RUN wget -qO- https://get.pnpm.io/install.sh | ENV="$HOME/.shrc" SHELL="$(which sh)" sh - \
    && ln -s $HOME/.local/share/pnpm/pnpm /usr/local/bin/pnpm

COPY package.json pnpm-lock.yaml ./
RUN pnpm install --frozen-lockfile

COPY --from=composer-builder /app /app

RUN pnpm run build


FROM dunglas/frankenphp:php8.4-alpine

WORKDIR /app

COPY --from=node-builder /app /app

RUN install-php-extensions intl zip exif pcntl pdo_mysql redis opcache

RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan filament:upgrade

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8000

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:8000/up || exit 1

ENTRYPOINT ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=8000"]