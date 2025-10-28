FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    git unzip zip libicu-dev libxml2-dev libzip-dev \
    && docker-php-ext-install intl zip calendar

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

CMD ["php", "./vendor/bin/pest"]
