FROM php:8.2-apache

# Устанавливаем расширение intl
RUN apt-get update && apt-get install -y libicu-dev \
  && docker-php-ext-install intl

# Копируем проект
COPY . /var/www/html/
