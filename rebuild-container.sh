#!/bin/bash

# Stop and remove existing containers
podman rm -f $(podman ps -a -q)

# Re-run podman-compose
cd /Users/vien.le/code_projects/real-time-quiz && podman-compose up -d

# Install composer dependencies
podman exec real-time-quiz_app_1 composer install

# Generate application key
podman exec real-time-quiz_app_1 php artisan key:generate

# Create the database tables
podman exec real-time-quiz_app_1 php artisan migrate --force

echo "Application is now running at http://localhost:8000"