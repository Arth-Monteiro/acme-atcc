FROM php:8.1.11-fpm-alpine3.16
ENV TZ=America/Sao_Paulo
RUN apk add --no-cache openssl bash nodejs npm postgresql-dev 
RUN docker-php-ext-install bcmath pdo pdo_pgsql
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN apk add --update apk-cron && rm -rf /var/cache/apk/*

WORKDIR /var/www/html

# RUN rm -rf /var/www/html
# RUN ln -s public html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./atcc-laravel /var/www/html
RUN chmod -R 777 /var/www/html/storage


RUN echo "* * * * * cd /var/www/html && php artisan schedule:run >> /var/log/cron.log" >> /etc/crontab
RUN crontab /etc/crontab
RUN touch /var/log/cron.log

EXPOSE 9000

CMD bash -c "crond && php-fpm"