FROM jaynos/phalcon:3.4.4

MAINTAINER Jayson Wang <jayson@laboys.org>

ENV PHP_XDEBUG_VERSION 2.9.4


RUN set -ex \
    && apk update \
    && apk add --virtual .build-deps \
        autoconf \
        bison \
        coreutils \
        curl \
        dpkg \
        dpkg-dev \
        file \
        gcc \
        g++ \
        libc-dev \
        make \
        re2c \
    \
    && mkdir -p "/usr/src" \
    && cd "/usr/src" \
    \
    && curl -SL "https://pecl.php.net/get/xdebug-${PHP_XDEBUG_VERSION}.tgz" -o "php-xdebug.tar.gz" \
    && tar xvf "php-xdebug.tar.gz" -C /usr/src \
    && cd "/usr/src/xdebug-${PHP_XDEBUG_VERSION}" \
    && phpize \
    && ./configure --with-php-config=`which php-config` --enable-xdebug \
    && make \
    && make install \
    && make clean \
    && echo 'zend_extension=xdebug' >> "${PHP_CONF_PATH}/php.ini" \
    \
    && cd "${PHP_HOME}" \
    && rm -rf /usr/src/* \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

RUN set -ex \
    && mkdir -p "/var/php/xdebug" \
    && chmod -R 777 /var/php/xdebug \
    && { \
        echo '[xdebug]'; \
        echo 'xdebug.profiler_enable_trigger = 1'; \
        echo 'xdebug.trace_output_dir = /var/php/xdebug'; \
        echo 'xdebug.profiler_output_dir = /var/php/xdebug'; \
        echo 'xdebug.remote_enable = 1'; \
        echo; \
       } >> "${PHP_CONF_PATH}/php.ini"
