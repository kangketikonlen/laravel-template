FROM ghcr.io/kangketikonlen/base-engine:1.2

WORKDIR /var/www/app

# copy application code
COPY . ./

# set composer related environment variables
ENV PATH="/composer/vendor/bin:$PATH" \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_VENDOR_DIR=/var/www/app/vendor \
    COMPOSER_HOME=/composer

# update the repository
RUN apt-get update -y \
    && DEBIAN_FRONTEND=noninteractive apt-get upgrade -y \
    && apt install iputils-ping -y \
    && apt install mysql-client -y

# install composer
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --ansi --version --no-interaction --no-dev

# add custom php-fpm pool settings, these get written at entrypoint startup
ENV FPM_PM_MAX_CHILDREN=73 \
    FPM_PM_START_SERVERS=16 \
    FPM_PM_MIN_SPARE_SERVERS=8 \
    FPM_PM_MAX_SPARE_SERVERS=16

# set application environment variables
ENV APP_NAME=LARAPULSE \
    APP_ENV=production \
    APP_KEY=base64:Z2CLHUnXQgNF0+yu+05Ofd9gewuoHURVVVXV4ku9xwU= \
    APP_DEBUG=false

# set log variables
ENV LOG_CHANNEL=daily \
    LOG_LEVEL=error

# set database env variable
ENV DB_CONNECTION=mysql \
    DB_HOST= \
    DB_PORT= \
    DB_DATABASE= \
    DB_USERNAME= \
    DB_PASSWORD=

# set others env variables
ENV BROADCAST_DRIVER=log \
    CACHE_DRIVER=file \
    FILESYSTEM_DISK=local \
    QUEUE_CONNECTION=sync \
    SESSION_DRIVER=database \
    SESSION_LIFETIME=120

# copy entrypoint files
COPY .docker/bin/docker-php-entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN dos2unix /usr/local/bin/docker-php-entrypoint

# copy nginx configuration
COPY .docker/conf/nginx.conf /etc/nginx/nginx.conf
COPY .docker/conf/default.conf /etc/nginx/sites-available/default

# install composer dependencies
RUN composer install --no-scripts --no-autoloader --ansi --no-interaction \
    && composer dump-autoload -o

# install nodejs dependencies
RUN npm install --silent --no-optional \
    && npm run production

# Create laravel log file.
RUN touch /var/www/app/storage/logs/laravel.log
RUN chmod -R 0777 /var/www/app/storage/logs

# setup ownership
RUN chmod -R 777 /var/www/app/storage \
    && chmod -R 777 /var/www/app/bootstrap/cache \
    && chown -R :www-data /var/www/app

# Setup docker cronjobs
COPY .docker/docker-php-schedule /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron
RUN crontab /etc/cron.d/laravel-cron
RUN touch /var/log/cron.log

# Copying bin files
COPY .docker/bin/laravel-schedule.sh /usr/bin/
RUN chmod +x /usr/bin/laravel-schedule.sh

# Cleaning up
RUN rm -rf resources/css \
    && rm -rf resources/font \
    && rm -rf resources/icon \
    && rm -rf resources/img \
    && rm -rf resources/js \
    && rm -rf resources/json \
    && rm -rf resources/lang \
    && rm -rf resources/sass \
    && rm -rf resources/favicon.ico

RUN rm -rf .git \
    && rm -rf .docker \
    && rm -rf .github \
    && rm -rf .editorconfig \
    && rm -rf .env \
    && rm -rf .env.example \
    && rm -rf .gitattributes \
    && rm -rf .gitignore \
    && rm -rf Dockerfile* \
    && rm -rf package* \
    && rm -rf phpunit.xml \
    && rm -rf README.md \
    && rm -rf webpack.mix.js \
    && rm -rf api

EXPOSE 80

# run supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
