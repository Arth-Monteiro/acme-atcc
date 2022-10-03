FROM php:8.2.0RC3-fpm-alpine3.16
RUN apk add --no-cache openssl bash nodejs npm postgresql-dev
RUN docker-php-ext-install bcmath pdo pdo_pgsql

WORKDIR /var/www/html

# RUN rm -rf /var/www/html
# RUN ln -s public html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./atcc-laravel /var/www/html

RUN chmod -R 777 /var/www/html/storage

EXPOSE 9000

ENTRYPOINT [ "php-fpm" ]