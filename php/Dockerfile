FROM php:8.1-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install sockets && docker-php-ext-enable sockets
RUN apt-get update && apt-get upgrade -y