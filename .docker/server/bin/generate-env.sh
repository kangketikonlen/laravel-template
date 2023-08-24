#!/bin/bash

# Check if .env file exists
if [ -f .env ]; then
    echo ".env file already exists. Aborting script."
    exit 0
fi

# Source existing .env
. ../../.env.example

# Creating variables
name=$(echo "$APP_NAME" | tr '[:upper:]' '[:lower:]')

# Generate a random 8-character alphanumeric string
generate_random_string() {
    openssl rand -base64 6 | tr -d "=+/"; echo
}

# Create a new .env file
cat > .env <<EOF
APP_NAME=${name}
APP_ENV=production
APP_DEBUG=false

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=${name}-database
DB_PORT=3306
DB_DATABASE=${name}
DB_USERNAME=$(generate_random_string)
DB_PASSWORD=$(generate_random_string)

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=database
SESSION_LIFETIME=120

DOCKER_APP_PORT=8004
DOCKER_DBMS_PORT=1004
DOCKER_DATABASE_PORT=3304
DOCKER_DATABASE_HOST=${name}-database
DOCKER_DATABASE_NAME=${name}
DOCKER_DATABASE_USERNAME=${name}-$(generate_random_string)
DOCKER_DATABASE_PASSWORD=$(generate_random_string)
DOCKER_IMAGE_VERSION=0.1
TZ=Asia/Jakarta
EOF

echo "New .env file generated with random values."
