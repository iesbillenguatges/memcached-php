FROM php:8.2-apache

# Instal·lar Memcached client
RUN apt-get update &&     apt-get install -y libmemcached-dev zlib1g-dev &&     pecl install memcached &&     docker-php-ext-enable memcached

# Copiar fitxers de configuració i codi
COPY php.ini /usr/local/etc/php/
COPY index.php /var/www/html/

EXPOSE 80
