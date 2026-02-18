FROM php:8.2-apache

WORKDIR /var/www/html/

# Installs
RUN apt update \
    && apt install -y --no-install-recommends \
    locales \
    libmagickwand-dev \
    libzip-dev \
    vim \
    wget \
    openssh-client \
    dnsutils \
    && rm -rf /var/lib/apt/lists/*

# Locales & timezone
ENV TZ=Europe/Paris \
    LANGUAGE=en_US.UTF-8 \
    LANG=en_US.UTF-8 \
    LC_ALL=en_US.UTF-8
RUN sed -i '/en_US.UTF-8/s/^# //g' /etc/locale.gen && \
    sed -i '/fr_FR.UTF-8/s/^# //g' /etc/locale.gen && \
    locale-gen
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/${TZ} /etc/localtime

# PHP config and extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN printf "\n" | pecl install zip
RUN docker-php-ext-enable zip

# Install Composer
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

# Permissions
ARG UID=1000
ARG GID=1000
RUN usermod -u ${UID} -o www-data
RUN groupmod -g ${GID} -o www-data
RUN chown -R www-data:www-data /var/www

# Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite


