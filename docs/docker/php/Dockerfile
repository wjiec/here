FROM alpine:3.10

MAINTAINER Jayson Wang <jayson@laboys.org>

ENV PHP_VERSION 7.3.10
ENV PHP_HOME /usr/local/php
ENV PHP_CONF_PATH /usr/local/php/etc


RUN set -ex \
    && addgroup -S php \
    && adduser -S -D -H -G php php \
    \
    && apk update \
    && apk add --virtual .build-deps \
        autoconf \
        bison \
        coreutils \
        curl \
        curl-dev \
        dpkg \
        dpkg-dev \
        file \
        gcc \
        gettext \
        gettext-dev \
        g++ \
        libc-dev \
        libedit-dev \
        libmcrypt-dev \
        libxml2-dev \
        libpng-dev \
        libzip-dev \
        make \
        openssl-dev \
        pcre-dev \
        postgresql-dev \
        pkgconf \
        re2c \
        tar \
        xz \
    \
    && mkdir -p "/usr/src" \
    && curl -SL "http://php.net/get/php-${PHP_VERSION}.tar.gz/from/this/mirror" -o php.tar.gz \
    \
    && tar xvf php.tar.gz -C /usr/src \
    && rm -rf php.tar.gz* \
    \
    && mkdir -p "${PHP_HOME}" \
    && mkdir -p "${PHP_CONF_PATH}/conf.d" \
    \
    && export CFLAGS="-fstack-protector-strong -fpic -fpie -O2" \
    && export CPPFLAGS="-fstack-protector-strong -fpic -fpie -O2" \
    && export LDFLAGS="-Wl,-O1 -Wl,--hash-style=both -pie" \
    \
    && apk add --virtual .runtime-deps \
        ca-certificates \
        openssl \
    \
    && cd "/usr/src/php-${PHP_VERSION}" \
    && ./configure \
        \
        --build="$(dpkg-architecture --query DEB_BUILD_GNU_TYPE)" \
        --prefix="${PHP_HOME}" \
        --with-config-file-path="${PHP_CONF_PATH}" \
        --with-config-file-scan-dir="${PHP_CONF_PATH}/conf.d" \
        \
        --with-fpm-user=php \
        --with-fpm-group=php \
        \
        --bindir="${PHP_HOME}/bin" \
        --sbindir="${PHP_HOME}/sbin" \
        --includedir="${PHP_HOME}/include" \
        --libdir="${PHP_HOME}/lib" \
        \
        --enable-fpm \
        --disable-cgi \
        \
        --with-curl \
        --with-gd \
        --with-gettext \
        --with-iconv \
        --with-libzip \
        --with-mysqli \
        --with-openssl \
        --with-pdo-mysql=mysqlnd \
        --with-pdo-pgsql \
        --with-pgsql \
        --with-zlib \
        \
        --enable-bcmath \
        --enable-exif \
        --enable-ftp \
        --enable-mbregex \
        --enable-mbstring \
        --enable-mysqlnd \
        --enable-opcache \
        --enable-pcntl \
        --enable-sockets \
        \
        --disable-fileinfo \
    \
    && make -j "$(nproc)" \
    && make install \
    && make clean \
    \
    && cd "${PHP_HOME}" \
    && rm -rf /usr/src/* \
    \
    && { find . -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    \
    && PHP_RUNTIME_DEPS="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive $PHP_HOME \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )" \
    && apk add --virtual .php-runtime-deps $PHP_RUNTIME_DEPS \
    && apk del .build-deps \
    \
    && unset CFLAGS \
    && unset CPPFLAGS \
    && unset LDFLAGS \
    \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

RUN set -ex \
    && cd ${PHP_CONF_PATH} \
    && if [ -d php-fpm.d ]; then \
           cp php-fpm.conf.default php-fpm.conf; \
           cp php-fpm.d/www.conf.default php-fpm.d/www.conf; \
       else \
           mkdir php-fpm.d; \
           cp php-fpm.conf.default php-fpm.d/www.conf; \
           { \
               echo '[global]'; \
           	   echo 'include=etc/php-fpm.d/*.conf'; \
           } | tee php-fpm.conf; \
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
       } | tee php-fpm.d/zzz.conf


ENV PATH "${PHP_HOME}/bin:${PHP_HOME}/sbin:${PATH}"
WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm"]
