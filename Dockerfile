# Dockerfile
FROM php:8.1-fpm

# Instale as extensões do PHP e o Composer
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN rm -rf /var/www/html

RUN ln -s public html

EXPOSE 9000

CMD ["php-fpm"]
