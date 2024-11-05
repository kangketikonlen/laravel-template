FROM ghcr.io/kangketikonlen/alpine-engine:latest

WORKDIR /var/www/app

# Install required packages and copy application code in one step
COPY . ./
RUN apk add --no-cache php82-iconv php82-xmlreader \
    && composer install --no-dev --no-scripts --no-autoloader --ansi --no-interaction \
    && composer dump-autoload -o \
    && npm install -g laravel-echo-server \
    && npm install --silent --no-optional \
    && npm run production

# Add custom php-fpm pool settings as environment variables
ENV FPM_PM_MAX_CHILDREN=73 \
    FPM_PM_START_SERVERS=16 \
    FPM_PM_MIN_SPARE_SERVERS=8 \
    FPM_PM_MAX_SPARE_SERVERS=16

# Application and log environment variables
ENV APP_NAME=LARAPULSE \
    APP_ENV=production \
    APP_KEY=base64:Z2CLHUnXQgNF0+yu+05Ofd9gewuoHURVVVXV4ku9xwU= \
    APP_DEBUG=false \
    LOG_CHANNEL=daily \
    LOG_LEVEL=error

# Database and other environment variables
ENV DB_CONNECTION=mysql \
    DB_HOST=$DB_DOCKER_HOST \
    DB_PORT= \
    DB_DATABASE= \
    DB_USERNAME= \
    DB_PASSWORD= \
    BROADCAST_DRIVER=log \
    CACHE_DRIVER=file \
    FILESYSTEM_DISK=local \
    QUEUE_CONNECTION=sync \
    SESSION_DRIVER=database \
    SESSION_LIFETIME=120

# Copy and set permissions for entrypoint and shell scripts in one step
COPY .docker/bin/docker-php-entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN dos2unix /usr/local/bin/docker-php-entrypoint

# Copy configuration files and setup nginx, supervisord, and cron jobs in one step
COPY .docker/conf/nginx.conf /etc/nginx/nginx.conf
COPY .docker/conf/default.conf /etc/nginx/http.d/default.conf
COPY .docker/conf/supervisord.conf /etc/supervisord.conf
COPY .docker/docker-php-schedule /etc/cron.d/laravel-cron
COPY .docker/bin/laravel-schedule.sh /usr/bin/
RUN chmod 0644 /etc/cron.d/laravel-cron \
    && chmod +x /usr/bin/laravel-schedule.sh \
    && crontab /etc/cron.d/laravel-cron \
    && touch /var/log/cron.log

# Setup permissions and create log file in one step
RUN touch /var/www/app/storage/logs/laravel.log \
    && chmod -R 777 /var/www/app/storage/logs \
    && chmod -R 777 /var/www/app/storage \
    && chmod -R 777 /var/www/app/bootstrap/cache \
    && chown -R :nginx /var/www/app

# Clean up unnecessary files in one step to minimize layers
RUN rm -rf resources/{css,font,icon,img,js,json,lang,sass,plugin,favicon.ico} \
    && rm -rf .git .docker .github .editorconfig .env .env.example .gitattributes .gitignore Dockerfile* \
    && rm -rf package* phpunit.xml README.md webpack.mix.js api *.md phpstan.neon node_modules

EXPOSE 80

# Run supervisord
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
