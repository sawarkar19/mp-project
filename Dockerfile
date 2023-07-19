FROM php:8.2-fpm

# Set working directory

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    default-mysql-client 
     

# Clear cache
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd 
RUN docker-php-ext-install gd

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions; \
    install-php-extensions  bcmath redis calendar exif FFI gettext igbinary imagick mysqli pcntl shmop sockets sysvmsg sysvsem sysvshm xsl zip


#RUN docker-php-ext-install bcmath bz2 calendar Core ctype curl date dom exif FFI fileinfo filter ftp gd gettext hash iconv igbinary imagick json libxml mbstring mysqli mysqlnd openssl pcntl pcre PDO pdo_mysql Phar posix readline redis Reflection session shmop SimpleXML sockets sodium SPL standard sysvmsg sysvsem sysvshm tokenizer xml xmlreader xmlwriter xsl zip zlib

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
#RUN groupadd -g 1000 www
#RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www



# Copy existing application directory permissions
#COPY --chown=www:www . /var/www

# Change current user to www
USER root

# Expose port 9000 and start php-fpm server


RUN chown www-data:www-data /var/www/

RUN chmod 777 -R /var/www/

EXPOSE 9000
CMD ["php-fpm"]

