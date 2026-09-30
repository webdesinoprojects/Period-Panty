#!/bin/bash
# Starts MariaDB, then Apache, in a single container.
#
# Unlike the development entrypoint this NEVER imports a SQL seed. Restoring a
# database is a deliberate one-off; doing it on boot risks a restart quietly
# wiping or duplicating live data. The database is created empty if missing and
# the operator restores into it once (see DEPLOY.md).
set -e

DB_NAME="${DB_NAME:-dexte}"
DB_USER="${DB_USER:-dexte}"
DB_PASS="${DB_PASS:-}"

if [ -z "$DB_PASS" ]; then
    echo "!! DB_PASS is empty. Set it in .env before starting." >&2
    exit 1
fi

mkdir -p /run/mysqld
chown -R mysql:mysql /run/mysqld /var/lib/mysql

if [ ! -d /var/lib/mysql/mysql ]; then
    echo ">> Initialising MariaDB data directory..."
    mariadb-install-db --user=mysql --datadir=/var/lib/mysql \
        --auth-root-authentication-method=normal >/dev/null
fi

echo ">> Starting MariaDB..."
mysqld_safe --datadir=/var/lib/mysql --skip-networking=0 &

for i in $(seq 1 90); do
    if mysqladmin ping --silent 2>/dev/null; then
        echo ">> MariaDB is up."
        break
    fi
    sleep 1
done

# Create the database and user if absent. Existing data is never touched.
mysql -u root <<SQL
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
ALTER USER '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;
SQL

TABLES=$(mysql -u root -N -e "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='${DB_NAME}'" 2>/dev/null || echo 0)
if [ "${TABLES:-0}" -eq 0 ]; then
    echo ">> NOTE: '${DB_NAME}' has no tables yet. Import your dump - see DEPLOY.md."
else
    echo ">> Database '${DB_NAME}' has ${TABLES} tables."
fi

# application/config/*.php read their credentials from the environment so that
# nothing secret is committed. Apache has to hand those variables to PHP, so
# the conf is written here at runtime from the values the container was given.
{
    echo "SetEnv DB_HOST localhost"
    echo "SetEnv DB_USER ${DB_USER}"
    echo "SetEnv DB_PASS ${DB_PASS}"
    echo "SetEnv DB_NAME ${DB_NAME}"
    echo "SetEnv RAZOR_KEY_ID ${RAZOR_KEY_ID:-}"
    echo "SetEnv RAZOR_KEY_SECRET ${RAZOR_KEY_SECRET:-}"
} > /etc/apache2/conf-available/zz-app-env.conf
a2enconf zz-app-env >/dev/null 2>&1 || true

# uploads/ is bind-mounted from the host so that customer and product images
# survive rebuilds - which also means the host's ownership applies to it, not
# the image's. Apache runs as www-data, so without this the admin panel cannot
# save new product images (existing ones still render, which makes it look
# fine until someone tries to add a product). No-op when nothing is mounted.
chown -R www-data:www-data /var/www/html/uploads 2>/dev/null || true

echo ">> Starting Apache (foreground)..."
exec apache2-foreground
