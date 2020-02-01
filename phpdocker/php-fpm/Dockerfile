FROM phpdockerio/php74-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install wget

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.4-mysql php-redis php-xdebug php7.4-bcmath php7.4-gd php-imagick php7.4-imap php7.4-ldap php-mongodb php7.4-odbc php7.4-xsl php-yaml \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN wget http://getcomposer.org/composer.phar && chmod 755 composer.phar && mv composer.phar /usr/local/bin/composer

RUN echo 'alias c="cd /application/bin && php console"' >> ~/.bashrc
