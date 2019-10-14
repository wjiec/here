FROM alpine:3.10

MAINTAINER Jayson Wang <jayson@laboys.org>

ENV REDIS_VERSION 5.0.5
ENV REDIS_HOME /usr/local/redis
ENV REDIS_DATA_DIR /var/redis


RUN set -ex \
    && addgroup -S redis \
    && adduser -S  -D -H -G redis redis \
    \
    && apk update \
    && apk add --virtual .build-deps \
        curl \
        gcc \
        libc-dev \
        linux-headers \
        make \
    \
    && mkdir -p "/usr/src" \
    && curl -SL "http://download.redis.io/releases/redis-${REDIS_VERSION}.tar.gz" -o redis.tar.gz \
    \
    && tar xvf redis.tar.gz -C /usr/src \
    && rm -rf redis.tar.gz* \
    \
    && cd "/usr/src/redis-${REDIS_VERSION}" \
    && export PREFIX="${REDIS_HOME}" \
    \
    && grep -q '^#define CONFIG_DEFAULT_PROTECTED_MODE 1$' ./src/server.h \
    && sed -ri 's/^(#define CONFIG_DEFAULT_PROTECTED_MODE) 1$/\1 0/' ./src/server.h \
    && grep -q '^#define CONFIG_DEFAULT_PROTECTED_MODE 0$' ./src/server.h \
    \
    && make \
    && make install \
    && make clean \
    \
    && cd "${REDIS_HOME}" \
    && rm -rf /usr/src/* \
    \
    && { find . -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    && REDIS_RUNTIME_DEPS="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive ${REDIS_HOME} \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
        )" \
    && apk add --virtual .redis-runtime-deps $REDIS_RUNTIME_DEPS \
    && apk del .build-deps \
    \
    && unset PREFIX \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

RUN set -ex \
    && mkdir -p "${REDIS_DATA_DIR}" \
    && chown -R redis:redis "${REDIS_DATA_DIR}"

RUN set -ex \
    && { \
           echo; \
           echo '# WARNING overcommit_memory is set to 0! Background save may fail under low memory condition.'; \
           echo 'vm.overcommit_memory = 1'; \
           echo; \
           echo '# WARNING: The TCP backlog setting of 511 cannot be enforced'; \
           echo 'net.core.somaxconn = 1024'; \
       } >> /etc/sysctl.conf


ENV PATH "${REDIS_HOME}/bin:${PATH}"
VOLUME ["/var/redis"]

EXPOSE 6379

WORKDIR /var/redis
CMD ["redis-server"]
