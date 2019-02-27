# minial install nginx
FROM alpine:3.6

# author
MAINTAINER Jayson Wang <jayson@laboys.org>

# environments for nginx
ENV NGINX_VERSION 1.12.2
ENV NGINX_HOME "/usr/local/nginx"
ENV NGINX_CONF_PATH "${NGINX_HOME}/conf"
ENV NGINX_VHOST_CONF_PATH "${NGINX_HOME}/conf/vhost"
ENV NGINX_EXTRA_CONF_PATH "${NGINX_HOME}/conf/extra"


# install build deps and fetch/build/install nginx
RUN set -ex \
    && addgroup -S -g 82 nginx \
    && adduser -S -D -H -G nginx -u 82 nginx \
    \
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
        --sbin-path="${NGINX_HOME}/bin/nginx" \
        --conf-path="${NGINX_CONF_PATH}/nginx.conf" \
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
    && cd "${NGINX_HOME}" \
    && rm -rf /usr/src/* \
    \
    && mkdir -p "${NGINX_VHOST_CONF_PATH}" \
    && mkdir -p "${NGINX_EXTRA_CONF_PATH}" \
    && chown -R nginx:nginx /usr/local/nginx \
    \
    && { find . -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    && NGINX_RUNTIME_DEPS="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/nginx \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
       )" \
    && apk add --virtual .nginx-runtime-deps $NGINX_RUNTIME_DEPS \
    && apk del .build-deps \
    \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*


# override configure by default
COPY nginx.conf /usr/local/nginx/conf/nginx.conf

# executeable path
ENV PATH "${NGINX_HOME}/bin:${PATH}"

# expose port number
EXPOSE 80

# workshop
WORKDIR /var/www

# start nginx server
CMD ["nginx"]
