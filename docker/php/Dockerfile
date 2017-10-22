# minial install php7 for `Here`
FROM alpine:latest

# author info
MAINTAINER Wang <shadowman@shellboot.com>

# China mirrors
RUN set -x \
    && country=`wget -T1 -q -O- google.com 2>&1 | sed -nr 's/.*(timed\ out).*/China/p'` \
    && if [ "$country" = "China" ]; then \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/main' > /etc/apk/repositories; \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/community' >> /etc/apk/repositories; \
       fi;

# build dependencies
RUN apk add --no-cache --virtual .build-deps \
        autoconf \
        bison \
        dpkg \
        dpkg-dev \
        file \
        g++ \
        gcc \
        libc-dev \
        make \
        pcre-dev \
        pkgconf \
        re2c \
        coreutils \
        file \
        curl-dev \
        g++ \
        gcc \
        libc-dev \
        gettext \
        gettext-dev \
        libedit-dev \
        openssl-dev \
        libxml2-dev \
        libmcrypt-dev \
        curl \
        tar \
        xz

# create user
RUN set -x \
    && addgroup -S -g 82 www \
    && adduser -S -D -H -G www -u 82 www

# environment for php7
ENV PHP_VERSION 7.1.10
ENV PHP_HOME /usr/local/php7
ENV PHP_CONF_PATH /usr/local/php7/etc

# fetch php
RUN mkdir -p "/usr/src" \
    && curl -SL "http://php.net/get/php-$PHP_VERSION.tar.gz/from/this/mirror" -o php.tar.gz \
    && tar xvf php.tar.gz -C /usr/src \
    && rm -rf php.tar.gz

# build php
RUN mkdir -p "$PHP_HOME" \
    && mkdir -p "$PHP_CONF_PATH/conf.d" \
    && export CFLAGS="-fstack-protector-strong -fpic -fpie -O2" \
    && export CPPFLAGS="-fstack-protector-strong -fpic -fpie -O2" \
    && LDFLAGS="-Wl,-O1 -Wl,--hash-style=both -pie" \
    && apk add --no-cache --virtual .runtime-deps \
        openssl \
        ca-certificates \
    && cd "/usr/src/php-$PHP_VERSION" \
    && ./configure \
        --build="$(dpkg-architecture --query DEB_BUILD_GNU_TYPE)" \
        --prefix="$PHP_HOME" \
        --with-config-file-path="$PHP_CONF_PATH" \
        --with-config-file-scan-dir="$PHP_CONF_PATH/conf.d" \
        \
        --with-fpm-user=www \
        --with-fpm-group=www \
        \
        --bindir=/usr/local/php7/bin \
        --sbindir=/usr/local/php7/sbin \
        --includedir=/usr/local/php7/include \
        --libdir=/usr/local/php7/lib \
        \
        --disable-cgi \
        --enable-fpm \
        \
        --with-iconv \
        --with-openssl \
        --with-zlib \
        --with-curl \
        --with-mcrypt \
        --with-mysqli \
        --with-pdo-mysql=shared,mysqlnd \
        --with-gettext \
        \
        --enable-zip \
        --enable-ftp \
        --enable-mbstring \
        --enable-mbregex \
        --enable-opcache \
        --enable-mysqlnd \
        --enable-sockets \
        \
        --disable-fileinfo \
    && make -j "$(nproc)" \
    && make install \
    && make clean \
    && cd "$PHP_HOME" \
    && rm -rf "/usr/src/php-$PHP_VERSION" \
    && { find . -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    && apk del .build-deps
