# minial install nginx
FROM alpine:3.6

# author
MAINTAINER Wang <jayson@laboys.org>

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

# environments for nginx
ENV NGINX_VERSION 1.12.2
ENV NGINX_HOME /usr/local/nginx
ENV NGINX_CONF_PATH "$NGINX_HOME/etc"

# install build deps and fetch/build/install nginx
RUN set -ex \
    && apk update \
    && apk add --virtual .build-deps \
        ca-certificates \
        curl \
        gcc \
        make \
        libc-dev \
        expat-dev \
        pcre-dev \
        openssl-dev \
        perl-dev \
    \
    && mkdir -p "/usr/src" \
    && curl -SL "http://nginx.org/download/nginx-$NGINX_VERSION.tar.gz" -o nginx.tar.gz \
    \
    && tar xvf nginx.tar.gz -C /usr/src \
    && rm -rf nginx.tar.gz* \
    \
    && mkdir -p "$NGINX_HOME" \
    && apk add --virtual \
        openssl \
    \
    && cd "/usr/src/nginx-$NGINX_VERSION" \
    && ./configure \
        --user=www \
        --group=www \
        \
        --build="$(dpkg-architecture --query DEB_BUILD_GNU_TYPE)" \
        --prefix=$NGINX_HOME \
        --sbin-path="$NGINX_HOME/bin/nginx" \
        --conf-path="$NGINX_HOME/etc/nginx.conf" \
        --http-log-path=/proc/self/fd/1 \
        --error-log-path=/proc/self/fd/2 \
        \
        --with-threads \
        --with-poll_module \
        --with-http_ssl_module \
        --with-http_v2_module \
        --with-http_realip_module \
        --with-http_addition_module \
        --with-http_auth_request_module \
        --with-http_dav_module \
        --with-http_stub_status_module \
        --with-http_gzip_static_module \
        --with-http_perl_module \
        --with-pcre-jit \
    \
    && make \
    && make install \
    && make clean \
    \
    && cd "$NGINX_HOME" \
    && rm -rf /usr/src/* \
    \
    && chown -R www:www /usr/local/nginx \
    && { \
           echo; \
           echo '# stay in the foreground so Docker has a process to track'; \
           echo 'daemon off;'; \
       } >> /usr/local/nginx/etc/nginx.conf \
    \
    && { find . -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    && nginxRuntimeDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/nginx \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
       )" \
    && apk add --virtual .nginx-runtime-deps $nginxRuntimeDeps \
    && apk del .build-deps \
    \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

ENV PATH $NGINX_HOME/bin:$PATH
WORKDIR /var/www
EXPOSE 80
CMD ["nginx"]
