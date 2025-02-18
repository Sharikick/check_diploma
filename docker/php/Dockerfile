FROM php:8.2-fpm

RUN apt-get update

RUN apt-get install -y curl git unzip libpq-dev build-essential

RUN apt-get -f install -y

RUN apt-get install -y libzip-dev zip

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql zip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

ENTRYPOINT ["php-fpm"]
