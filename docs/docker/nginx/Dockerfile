FROM alpine:3.10

MAINTAINER Jayson Wang <jayson@laboys.org>

ENV NGINX_VERSION 1.12.2
ENV NGINX_HOME "/usr/local/nginx"
ENV NGINX_CONF_PATH "${NGINX_HOME}/conf"


RUN set -ex \
    && addgroup -S nginx \
    && adduser -S -D -H -G nginx nginx \
    \
    && apk update \
    && apk add --virtual .build-deps \
        ca-certificates \
        curl \
        dpkg \
        dpkg-dev \
        gcc \
        g++ \
        make \
        libc-dev \
        expat-dev \
        pcre-dev \
        openssl-dev \
        zlib-dev \
    \
    && mkdir -p "/usr/src" \
    && curl -SL "http://nginx.org/download/nginx-${NGINX_VERSION}.tar.gz" -o nginx.tar.gz \
    \
    && tar xvf nginx.tar.gz -C /usr/src \
    && rm -rf nginx.tar.gz* \
    \
    && mkdir -p "${NGINX_HOME}" \
    && apk add --virtual .runtime-deps \
        openssl \
    \
    && cd "/usr/src/nginx-${NGINX_VERSION}" \
    && ./configure \
        --user=nginx \
        --group=nginx \
        \
        --build="$(dpkg-architecture --query DEB_BUILD_GNU_TYPE)" \
        --prefix="${NGINX_HOME}" \
        --sbin-path="${NGINX_HOME}/sbin/nginx" \
        --conf-path="${NGINX_CONF_PATH}/nginx.conf" \
        --http-log-path=/proc/self/fd/1 \
        --error-log-path=/proc/self/fd/2 \
        \
        --without-select_module \
        --with-poll_module \
        --with-threads \
        \
        --with-http_ssl_module \
        --with-http_v2_module \
        --with-http_realip_module \
        --with-http_addition_module \
        --with-http_auth_request_module \
        --with-http_dav_module \
        --with-http_stub_status_module \
        --with-http_gzip_static_module \
        --with-pcre-jit \
        \
        --with-cc-opt=-Wno-error \
    \
    && make \
    && make install \
    && make clean \
    \
    && cd "${NGINX_HOME}" \
    && rm -rf /usr/src/* \
    \
    && chown -R nginx:nginx /usr/local/nginx \
    \
    && { find . -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    && NGINX_RUNTIME_DEPS="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive ${NGINX_HOME} \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
        )" \
    && apk add --virtual .nginx-runtime-deps $NGINX_RUNTIME_DEPS \
    && apk del .build-deps \
    \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*


ENV PATH "${NGINX_HOME}/sbin:${PATH}"
VOLUME ["/var/www"]

EXPOSE 80
EXPOSE 443

WORKDIR /var/www
CMD ["nginx"]
