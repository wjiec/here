# from exists php images
FROM shellboot/rpi-php

# author info
MAINTAINER Wang <jayson@laboys.org>

# China mirrors and create www-user
RUN set -x \
    && country=`wget -T1 -q -O- google.com 2>&1 | sed -nr 's/.*(timed\ out).*/China/p'` \
    && if [ "$country" == "China" ]; then \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/main' > /etc/apk/repositories; \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/community' >> /etc/apk/repositories; \
       fi;


ENV PHP_REDIS_VERSION 4.1.1


# install deps and fetch/compile/install php-redis ext
RUN set -x \
    && apk update \
    && apk add --virtual .build-deps \
        autoconf \
        ca-certificates \
        coreutils \
        curl \
        curl-dev \
        gcc \
        g++ \
        libc-dev \
        make \
        re2c \
        tar \
        zlib-dev \
    \
    && mkdir -p "/usr/src" \
    && curl -SL "https://pecl.php.net/get/redis-$PHP_REDIS_VERSION.tgz" -o "php-redis.tar.gz" \
    && tar xvf "php-redis.tar.gz" -C /usr/src \
    && rm -rf "php-redis.tar.gz" \
    \
    && cd "/usr/src/redis-$PHP_REDIS_VERSION" \
    && phpize \
    && ./configure --with-php-config=`which php-config` \
    && make \
    && make install \
    && make clean \
    && cd "$PHP_HOME" \
    \
    && echo 'extension="redis.so"' >> "$PHP_HOME/etc/php.ini" \
    \
    && apk del .build-deps \
    \
    && rm -rf "/usr/src/*" \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*
