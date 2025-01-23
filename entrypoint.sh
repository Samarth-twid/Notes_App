#!/bin/bash

# Load environment variables from .env.docker
export $(grep -v '^#' .env.docker | xargs)

# Ensure MySQL container is running
echo "Starting MySQL container..."
docker-compose up -d db

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
until docker exec -it db mysqladmin ping -h "localhost" --silent; do
    sleep 1
done

# Create MySQL user and grant privileges
echo "Creating MySQL user and granting privileges..."
docker exec -i db mysql -u root -p"${MYSQL_ROOT_PASSWORD}" <<-EOSQL
    CREATE USER '${DB_USERNAME}'@'%' IDENTIFIED BY '${DB_PASSWORD}';
    GRANT ALL PRIVILEGES ON ${DB_DATABASE}.* TO '${DB_USERNAME}'@'%';
    FLUSH PRIVILEGES;
EOSQL

# Stop the database container after setup (optional)
echo "Stopping MySQL container..."
docker-compose stop db

# Build and start all containers
echo "Building and starting all containers..."
docker-compose up --build -d

# Run Laravel migrations after the app container is up
echo "Waiting for Laravel app to be ready..."
sleep 10  # Adjust this value if needed

echo "Running Laravel migrations..."
docker exec -it laravel-app php artisan migrate

echo "Setup completed successfully."
