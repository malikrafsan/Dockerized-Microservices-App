FROM php:8.0-apache
EXPOSE 8888

# Install dependencies (php mysql)
RUN rm -f /etc/apt/apt.conf.d/docker-clean \
    && apt-get update \
    && apt install libxml2-dev -y 
    
RUN docker-php-ext-install pdo pdo_mysql soap

# copy php.ini
COPY ./php.ini /usr/local/etc/php/php.ini
RUN a2enmod rewrite
