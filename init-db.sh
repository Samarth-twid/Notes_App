#!/bin/sh
set -e

export $(grep -v '^#' .env.docker | xargs)

until mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e 'SELECT 1'; do
    >&2 echo "MySQL is unavailable - sleeping"
    sleep 5
done

mysql -u root -p"$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS $DB_DATABASE;
    CREATE USER IF NOT EXISTS '$DB_USERNAME'@'%' IDENTIFIED WITH mysql_native_password BY '$DB_PASSWORD';
    GRANT ALL PRIVILEGES ON $DB_DATABASE.* TO '$DB_USERNAME'@'%';
    FLUSH PRIVILEGES;
    EXIT;
EOSQL
