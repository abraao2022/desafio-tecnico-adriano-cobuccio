FROM php:8.2-fpm

# Instala dependências e extensões do PHP
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath zip gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node + npm (útil pro Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

WORKDIR /var/www

COPY . .

RUN composer install

# Permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

EXPOSE 9000

CMD ["php-fpm"]
