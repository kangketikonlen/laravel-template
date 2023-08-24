#!/bin/bash

IMAGE_VERSION=1.0
sed -i "" "s/^\(DOCKER_IMAGE_VERSION=\).*/\1$IMAGE_VERSION/" .env

# Source existing .env
. .env

remove_and_run() {
  trap 'echo "Exiting function with status 1..."; exit 1' INT TERM
  docker rm -f ${APP_NAME}-app
  docker system prune -f
  docker volume prune -f
  docker image prune -a -f
  docker-compose up -d || exit 1

  echo -e "\nRunning clear config..."
  sleep 2
  docker exec -i ${APP_NAME}-app php artisan config:clear

  echo "Running optimize..."
  sleep 2
  docker exec -i ${APP_NAME}-app php artisan optimize

  echo "Running migrate..."
  sleep 2
  docker exec -i ${APP_NAME}-app php artisan migrate --force

  echo "Running seed..."
  sleep 2
  docker exec -i ${APP_NAME}-app php artisan db:seed --force

  echo "Running storage link..."
  sleep 2
  docker exec -i ${APP_NAME}-app php artisan storage:link --force

  echo "Running chmod on log folder..."
  sleep 2
  docker exec -i ${APP_NAME}-app chmod -R 0777 /var/www/app/storage/logs
}

if command -v docker-compose >/dev/null 2>&1; then
    echo "docker-compose is available"
    remove_and_run
    exit 0
else
    echo "docker-compose is not available"
    exit 1
fi
