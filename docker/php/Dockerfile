# minial install php7 for `Here`
FROM alpine:latest

# author info
MAINTAINER Wang <shadowman@shellboot.com>

# China mirrors and create www-user
RUN set -x \
    && country=`wget -T1 -q -O- google.com 2>&1 | sed -nr 's/.*(timed\ out).*/China/p'` \
    && if [ "$country" == "China" ]; then \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/main' > /etc/apk/repositories; \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/community' >> /etc/apk/repositories; \
       fi; \
    \
    addgroup -S -g 82 www \
    && adduser -S -D -H -G www -u 82 www

# environment for php7
ENV PHP_VERSION 7.1.10
ENV PHP_HOME /usr/local/php7
ENV PHP_CONF_PATH /usr/local/php7/etc

# install deps and fetch/compile/install php
RUN set -x \
    && apk update \
    && apk add --virtual .build-deps \
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
        xz \
    \
    && mkdir -p "/usr/src" \
    && country=`wget -T1 -q -O- google.com 2>&1 | sed -nr 's/.*(timed\ out).*/China/p'` \
    && if [ "$country" == "China" ]; then \
           curl -SL "http://cn2.php.net/get/php-7.1.10.tar.gz/from/this/mirror" -o php.tar.gz; \
       else \
           curl -SL "http://php.net/get/php-$PHP_VERSION.tar.gz/from/this/mirror" -o php.tar.gz; \
       fi; \
    unset country \
    && tar xvf php.tar.gz -C /usr/src \
    && rm -rf php.tar.gz \
    \
    && mkdir -p "$PHP_HOME" \
    && mkdir -p "$PHP_CONF_PATH/conf.d" \
    && export CFLAGS="-fstack-protector-strong -fpic -fpie -O2" \
    && export CPPFLAGS="-fstack-protector-strong -fpic -fpie -O2" \
    && LDFLAGS="-Wl,-O1 -Wl,--hash-style=both -pie" \
    && apk add --virtual .runtime-deps \
        ca-certificates \
        openssl \
    \
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
    && phpRuntimeDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/php7 \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )" \
    && apk add --virtual .php-runtime-deps $phpRuntimeDeps \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

# configure for php-fpm
WORKDIR /usr/local/php7/etc
RUN set -ex \
    && cd /usr/local/php7/etc \
    && if [ -d php-fpm.d ]; then \
           cp php-fpm.conf.default php-fpm.conf; \
           cp php-fpm.d/www.conf.default php-fpm.d/www.conf; \
       fi; \
    \
      { \
           echo '[global]'; \
           echo 'error_log = /proc/self/fd/2'; \
           echo; \
           echo '[www]'; \
           echo '; if we send this to /proc/self/fd/1, it never appears'; \
           echo 'access.log = /proc/self/fd/2'; \
           echo; \
           echo 'clear_env = no'; \
           echo; \
           echo '; Ensure worker stdout and stderr are sent to the main error log.'; \
           echo 'catch_workers_output = yes'; \
       } | tee php-fpm.d/docker.conf \
    && { \
           echo '[global]'; \
           echo 'daemonize = no'; \
           echo; \
           echo '[www]'; \
           echo 'listen = [::]:9000'; \
       } | tee php-fpm.d/php-fpm-server.conf

EXPOSE 9000
CMD ["/usr/local/php7/sbin/php-fpm"]
