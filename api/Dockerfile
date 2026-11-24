FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql \
    && a2enmod headers rewrite \
    && sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/api>\n    AllowOverride All\n    Require all granted\n</Directory>\n' > /etc/apache2/conf-available/api.conf \
    && a2enconf api \
    && rm -rf /var/lib/apt/lists/*

COPY index.php .htaccess /var/www/html/api/
COPY src/ /var/www/html/api/src/

EXPOSE 10000
