FROM jaynos/php

MAINTAINER Jayson Wang <jayson@laboys.org>

ENV PHP_HOME /usr/local/php
ENV PHP_CONF_PATH /usr/local/php/etc
ENV PHP_REDIS_VERSION 5.0.2
ENV PHP_PHALCON_VERSION "4.0.0-rc1"


RUN set -ex \
    && apk update \
    && apk add --virtual .build-deps \
        autoconf \
        bash \
        ca-certificates \
        coreutils \
        curl \
        curl-dev \
        file \
        gcc \
        git \
        g++ \
        libc-dev \
        make \
        pcre-dev \
        re2c \
        tar \
        zlib-dev \
    \
    && mkdir -p "/usr/src" \
    \
    && cd "/usr/src" \
    && git clone --depth=1 "https://github.com/jbboehr/php-psr.git" \
    && cd "/usr/src/php-psr" \
    && phpize \
    && ./configure --with-php-config=`which php-config` \
    && make \
    && make test \
    && make install \
    && make clean \
    && echo 'extension=psr' >> "${PHP_CONF_PATH}/php.ini" \
    \
    && cd "/usr/src" \
    && curl -SL "https://pecl.php.net/get/redis-${PHP_REDIS_VERSION}.tgz" -o "php-redis.tar.gz" \
    && tar xvf "php-redis.tar.gz" -C /usr/src \
    && cd "/usr/src/redis-${PHP_REDIS_VERSION}" \
    && phpize \
    && ./configure --with-php-config=`which php-config` \
    && make \
    && make install \
    && make clean \
    && echo 'extension=redis' >> "${PHP_CONF_PATH}/php.ini" \
    \
    && cd "/usr/src" \
    && git clone --depth=1 "https://github.com/phalcon/cphalcon.git" \
    && cd "/usr/src/cphalcon/build" \
    && ./install \
    && echo 'extension=phalcon' >> "${PHP_CONF_PATH}/php.ini" \
    \
    && cd "${PHP_HOME}/lib" \
    && { find psr.* -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    && { find redis.* -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    && { find phalcon.* -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    \
    && apk del .build-deps \
    && rm -rf /usr/src/* \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*


RUN set -ex \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    \
    && rm -rf /usr/src/* \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*


#RUN set -ex \
#    && composer global require "phalcon/devtools" \
#    && ln -s /root/.composer/vendor/bin/phalcon.php /usr/bin/phalcon
