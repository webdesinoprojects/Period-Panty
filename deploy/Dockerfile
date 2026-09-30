# DEXTE - production image
#
# Differs from the local development image in three ways:
#   * the build context is the repository root (which IS the site root), so the
#     code is copied with `COPY . /var/www/html/` rather than from a parent path
#   * no SQL seed is imported automatically; the database is restored once,
#     deliberately, by the operator
#   * database and payment credentials come from the environment, never baked in
#
# PHP 7.4 is not incidental: CodeIgniter 3.1.11 predates PHP 8 support, which
# arrived in 3.1.13. Running this in a container is what makes the host's own
# PHP version irrelevant.
FROM php:7.4-apache

# Debian 11 (bullseye) is EOL. deb.debian.org still serves its package index
# but the .deb pool is gone, so every apt-get install 404s. Point apt at the
# archive, which still carries the packages.
RUN printf 'deb http://archive.debian.org/debian bullseye main\n' > /etc/apt/sources.list \
    && printf 'Acquire::Check-Valid-Until "false";\n' > /etc/apt/apt.conf.d/99no-check-valid

# MariaDB server/client plus the libraries the PHP extensions need.
RUN apt-get update && apt-get install -y --no-install-recommends \
        mariadb-server \
        mariadb-client \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" mysqli pdo_mysql gd zip \
    && rm -rf /var/lib/apt/lists/*

# Apache: rewrite for CodeIgniter's front controller, honour .htaccess, and
# raise header limits (the cart posts large payloads).
RUN a2enmod rewrite \
    && sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf \
    && printf 'ServerName localhost\nLimitRequestLine 131072\nLimitRequestFieldSize 131072\nLimitRequestFields 200\n' \
        > /etc/apache2/conf-available/zz-limits.conf \
    && a2enconf zz-limits

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# base_url is derived from the request rather than hardcoded, so the same image
# serves an sslip.io hostname today and the real domain later with no rebuild.
# X-Forwarded-Proto is honoured, which is how the app emits https:// URLs when
# nginx terminates TLS in front of it.
COPY deploy/base_url.php /usr/local/etc/dexte-base-url.php
RUN sed -i "s|\$config\['base_url'\] = 'https://www.dexteshop.com/';|\$config['base_url'] = require '/usr/local/etc/dexte-base-url.php';|" \
        /var/www/html/application/config/config.php || true \
    # The shipped .htaccess forces HTTPS itself, which would loop behind a proxy
    # that already terminates TLS. nginx handles the redirect instead.
    && sed -i 's/RewriteCond %{HTTPS} off/#RewriteCond %{HTTPS} off/g' /var/www/html/.htaccess || true \
    && sed -i 's/RewriteRule (.*) https:\/\/%{HTTP_HOST}%{REQUEST_URI}/#RewriteRule (.*) https:\/\/%{HTTP_HOST}%{REQUEST_URI}/g' /var/www/html/.htaccess || true

RUN { \
        echo "mysqli.default_socket=/run/mysqld/mysqld.sock"; \
        echo "pdo_mysql.default_socket=/run/mysqld/mysqld.sock"; \
        echo "display_errors=Off"; \
        echo "display_startup_errors=Off"; \
        echo "error_reporting=E_ALL & ~E_NOTICE & ~E_DEPRECATED"; \
        echo "log_errors=On"; \
        echo "upload_max_filesize=64M"; \
        echo "post_max_size=64M"; \
        echo "max_execution_time=120"; \
    } > /usr/local/etc/php/conf.d/zz-app.ini

COPY deploy/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
CMD ["/usr/local/bin/entrypoint.sh"]
