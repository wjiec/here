FROM alpine:3.10

MAINTAINER Jayson Wang <jayson@laboys.org>

ENV LANG en_US.utf8
ENV PGSQL_VERSION 11.5
ENV PGSQL_HOME /usr/local/pgsql
ENV PGSQL_CONF_PATH /usr/local/pgsql/etc
ENV PGSQL_DATA_PATH /var/pgsql/data
ENV PGSQL_RUN_PATH /var/run/pgsql


RUN set -ex \
    && apk update \
    && apk add --virtual .build-deps \
        bison \
        coreutils \
        curl \
        dpkg-dev \
        flex \
        gcc \
        icu-dev \
        make \
        libc-dev \
        libedit-dev \
        libxml2-dev \
        linux-headers \
        openssl-dev \
        util-linux-dev \
        zlib-dev \
    \
    && mkdir -p "/usr/src" \
    && curl -SL "https://ftp.postgresql.org/pub/source/v${PGSQL_VERSION}/postgresql-${PGSQL_VERSION}.tar.bz2" -o pgsql.tar.bz2 \
    \
    && tar xvf pgsql.tar.bz2 -C /usr/src \
    && rm -rf pgsql.tar.bz2* \
    \
    && mkdir -p "${PGSQL_HOME}" \
    && mkdir -p "${PGSQL_CONF_PATH}" \
    \
    && cd "/usr/src/postgresql-${PGSQL_VERSION}" \
    && awk '$1 == "#define" && $2 == "DEFAULT_PGSOCKET_DIR" && $3 == "\"/tmp\"" { $3 = "\"/var/run/pgsql\""; print; next } { print }' src/include/pg_config_manual.h > src/include/pg_config_manual.h.new \
    && grep "${PGSQL_RUN_PATH}" src/include/pg_config_manual.h.new \
    && mv src/include/pg_config_manual.h.new src/include/pg_config_manual.h \
    \
    && wget -O config/config.guess 'https://git.savannah.gnu.org/cgit/config.git/plain/config.guess?id=7d3d27baf8107b630586c962c057e22149653deb' \
    && wget -O config/config.sub 'https://git.savannah.gnu.org/cgit/config.git/plain/config.sub?id=7d3d27baf8107b630586c962c057e22149653deb' \
    \
    && ./configure \
        \
        --prefix="${PGSQL_HOME}" \
        --sysconfdir="${PGSQL_CONF_PATH}" \
        --with-system-tzdata=/usr/share/zoneinfo \
        \
        --enable-thread-safety \
        --disable-rpath \
        \
        --with-uuid=e2fs \
        --with-gnu-ld \
        \
        --with-openssl \
        --with-libxml \
        --with-icu \
        \
    && make -j "$(nproc)"\
    && make install \
    \
    && cd "${PGSQL_HOME}" \
    && rm -rf /usr/src/* \
    \
    && { find . -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    \
    && PGSQL_RUNTIME_DEPS="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive $PGSQL_HOME \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )" \
    && apk add --virtual .pgsql-runtime-deps $PGSQL_RUNTIME_DEPS bash su-exec \
    && apk del .build-deps \
    \
    && find /usr/local -name '*.a' -delete \
    && rm -rf /usr/local/share/doc \
    && rm -rf /usr/local/share/man \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

RUN set -ex \
    && mkdir -p "${PGSQL_RUN_PATH}" \
    && chown -R postgres:postgres ${PGSQL_RUN_PATH} \
    && chmod 2777 ${PGSQL_RUN_PATH}

RUN set -ex \
    && mkdir -p "${PGSQL_DATA_PATH}" \
    && chown -R postgres:postgres "${PGSQL_DATA_PATH}" \
    && chmod 777 "${PGSQL_DATA_PATH}"

RUN set -ex \
    && sed -ri "s!^#?(listen_addresses)\s*=\s*\S+.*!\1 = '*'!" "${PGSQL_HOME}/share/postgresql.conf.sample"

COPY pgsql.sh /usr/local/bin/
RUN set -ex && chmod +x /usr/local/bin/pgsql.sh
ENV PATH "${PGSQL_HOME}/bin:${PATH}"
ENV PGDATA "${PGSQL_DATA_PATH}"

VOLUME /var/pgsql/data
WORKDIR /var/pgsql/data

EXPOSE 5432

ENTRYPOINT ["pgsql.sh"]
CMD ["postgres"]
