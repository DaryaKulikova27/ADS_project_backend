FROM php:8.3.7-fpm

# Set working directory 
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    exim4 \
    git \
    mc \
    man \
    vim \
    acl \
    python3 \
    systemctl \
    libpq-dev \
    libonig-dev \
    libicu-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxpm-dev \
    libvpx-dev \
    imagemagick \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    lua-zlib-dev \
    zip \
    unzip \
    curl \
    wget \
    && docker-php-ext-install -j$(nproc) bcmath iconv mbstring mysqli pdo pdo_mysql pgsql pdo_pgsql zip exif\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd 
 
# set up mailing
RUN sed -i 's@local@internet@' /etc/exim4/update-exim4.conf.conf \
  && update-exim4.conf

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY ./laravel-app /var/www/html
RUN chown -R www:www *
# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
