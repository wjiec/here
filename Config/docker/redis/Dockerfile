# minial install nginx
FROM alpine:latest

# author
MAINTAINER Wang <shadowman@shellboot.com>

# China mirrors and create www-user
RUN set -x \
    && country=`wget -T1 -q -O- google.com 2>&1 | sed -nr 's/.*(timed\ out).*/China/p'` \
    && if [ "$country" == "China" ]; then \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/main' > /etc/apk/repositories; \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/community' >> /etc/apk/repositories; \
       fi; \
    \
    addgroup -S redis \
    && adduser -S -G redis redis

# environments for nginx
ENV REDIS_VERSION 4.0.2
ENV REDIS_HOME /usr/local/redis
ENV REDIS_DATA_DIR /var/redis

# install build deps and fetch/build/install nginx
RUN set -ex \
    && apk update \
    && apk add --virtual .build-deps \
        gcc \
        libc-dev \
        linux-headers \
        make \
    \
    && mkdir -p "/usr/src" \
    && wget -O redis.tar.gz "http://download.redis.io/releases/redis-$REDIS_VERSION.tar.gz" \
    \
    && tar xvf redis.tar.gz -C /usr/src \
    && rm -rf redis.tar.gz* \
    \
    && cd "/usr/src/redis-$REDIS_VERSION" \
    && export PREFIX="$REDIS_HOME" \
    \
    && grep -q '^#define CONFIG_DEFAULT_PROTECTED_MODE 1$' ./src/server.h \
    && sed -ri 's!^(#define CONFIG_DEFAULT_PROTECTED_MODE) 1$!\1 0!' ./src/server.h \
    && grep -q '^#define CONFIG_DEFAULT_PROTECTED_MODE 0$' ./src/server.h \
    \
    && make \
    && make install \
    && make clean \
    \
    && cd "$REDIS_HOME" \
    && rm -rf "/usr/src/*" \
    \
    && { find . -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    && nginxRuntimeDeps="$( \
            scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/redis \
                | tr ',' '\n' \
                | sort -u \
                | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
       )" \
    && apk add --virtual .nginx-runtime-deps $nginxRuntimeDeps \
    && apk del .build-deps \
    \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

# make data folder and new configure
RUN mkdir -p "$REDIS_DATA_DIR" \
    && chown -R redis:redis "$REDIS_DATA_DIR"

COPY start-redis-server.sh /usr/local/redis/bin
ENV PATH $REDIS_HOME/bin:$PATH
VOLUME /var/redis
WORKDIR /var/redis
EXPOSE 6379
CMD ["start-redis-server"]
