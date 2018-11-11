# from exists php images
FROM shellboot/rpi-php:redis

# author info
MAINTAINER Wang <jayson@laboys.org>

# install deps and fetch/compile/install php-redis ext
# curl-dev: https://github.com/JJ/alpine-perl6/issues/3
RUN set -x \
    && apk update \
    && apk add --virtual .build-deps \
        autoconf \
        bash \
        ca-certificates \
        coreutils \
        curl \
        curl-dev \
        gcc \
        git \
        g++ \
        libc-dev \
        make \
        pcre-dev \
        re2c \
    \
    && mkdir -p "/usr/src" \
    && cd "/usr/src" \
    && git clone --depth=1 "https://github.com/phalcon/cphalcon.git" \
    \
    && cd "/usr/src/cphalcon/build" \
    && ./install \
    \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    \
    && cd "$PHP_HOME" \
    && echo 'extension="phalcon.so"' >> "${PHP_HOME}/etc/php.ini" \
    && composer global require "phalcon/devtools" \
    && ln -s /root/.composer/vendor/bin/phalcon.php /usr/bin/phalcon \
    \
    && apk del .build-deps \
    \
    && rm -rf /usr/src/* \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*
