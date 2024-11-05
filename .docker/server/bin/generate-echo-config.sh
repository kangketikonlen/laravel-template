#!/bin/bash

# Load the environment variables from the .env file
set -a
source .env # Adjust the path to your .env file as needed
set +a

# Create the configuration object
cat <<EOF >laravel-echo-server.json
{
    "authHost": "${APP_URL:-http://127.0.0.1:8000}",
    "authEndpoint": "/broadcasting/auth",
    "clients": [
        {
            "appId": "${APP_NAME:-f940897a2017f519}",
            "key": "${APP_KEY:-5e3f8630e4275abb727307d559a75c58}"
        }
    ],
    "database": "redis",
    "databaseConfig": {
        "redis": {
            "host": "${REDIS_HOST:-127.0.0.1}",
            "port": "${REDIS_PORT:-6379}"
        }
    },
    "devMode": "${DEV_MODE:-true}",
    "port": "${PORT:-6001}",
    "secureOptions": 67108864,
    "subscribers": {
        "http": "true",
        "redis": "true"
    }
}
EOF

echo "Configuration generated in laravel-echo-server.json"
