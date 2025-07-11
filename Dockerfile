FROM php:8.2-apache

# Instal·la les dependències per compilar extensions natives i memcached
RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    libz-dev \
    libevent-dev \
    pkg-config \
    libssl-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

# Còpia els teus fitxers PHP al contenidor
COPY index.php /var/www/html/

# Configuració recomanada d'Apache
EXPOSE 80
