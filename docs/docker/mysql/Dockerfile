# minial install mysql
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
    addgroup -S mysql \
    && adduser -S -G mysql mysql

# environments for mysql
ENV MYSQL_MAJOR_VERSION 5.7
ENV MYSQL_FULL_VERSION 5.7.21
ENV MYSQL_HOME "/usr/local/mysql"
ENV MYSQL_CONF_PATH "$MYSQL_HOME/etc"

# install build deps and fetch/build/install mysql
RUN set -ex \
    && apk update \
    && apk add --virtual .build-deps \
        bison \
        ca-certificates \
        cmake \
        curl \
        gcc \
        g++ \
        libc-dev \
        libtirpc \
        libtirpc-dev \
        make \
        ncurses \
        ncurses-dev \
        openssl-dev \
        perl \
        perl-dev \
        pwgen \
        rpcgen \
    \
    && mkdir -p "/usr/src" \
    && curl -SL "https://cdn.mysql.com/Downloads/MySQL-${MYSQL_MAJOR_VERSION}/mysql-${MYSQL_FULL_VERSION}.tar.gz" -o mysql.tar.gz \
    \
    && tar xvf mysql.tar.gz -C /usr/src \
    && rm -rf mysql.tar.gz* \
    \
    && mkdir -p "${MYSQL_HOME}" \
    && apk add --virtual \
        openssl \
    \
    && cd "/usr/src/mysql-${MYSQL_FULL_VERSION}" \
    \
    # https://bugs.mysql.com/bug.php?id=80322
    && { \
           echo "struct linux_sigevent {"; \
           echo "  union sigval sigev_value;"; \
           echo "  int sigev_signo;"; \
           echo "  int sigev_notify;"; \
           echo "  union {"; \
           echo "    int _pad[64-sizeof(int) * 2 + sizeof(union sigval)];"; \
           echo "    int _tid;"; \
           echo "  } _sigev_un;"; \
           echo "};"; \
           echo ; \
       } > __linux_sigevent.tmp \
    && sed -i '44 r __linux_sigevent.tmp' mysys/posix_timers.c \
    && rm -rf __linux_sigevent.tmp \
    && sed -i 's/struct sigevent sigev;/struct linux_sigevent sigev;/g' mysys/posix_timers.c \
    && sed -i 's/,\ \&sigev/,\ \(struct\ sigevent\ *\)\&sigev/g' mysys/posix_timers.c \
    \
    # https://stackoverflow.com/questions/16826898
    && sed -i 's/sigev.sigev_notify_thread_id/sigev._sigev_un._tid/g' mysys/posix_timers.c \
    \
    # http://buildroot-busybox.2317881.n4.nabble.com/RPC-h-and-busybox-td33821.html
    && ln -s /usr/include/tirpc/rpc /usr/include/rpc \
    && ln -s /usr/include/tirpc/netconfig.h /usr/include/netconfig.h \
    \
    && mkdir build \
    && cd build \
    \
    && export CFLAGS="-DSIGEV_THREAD_ID=4" \
    && cmake \
        -DDOWNLOAD_BOOST=1 \
        -DWITH_BOOST=/usr/src/boost-src \
        \
        -DWITH_EMBEDDED_SERVER=0 \
        -DWITH_EMBEDDED_SHARED_LIBRARY=0 \
        -DCMAKE_INSTALL_PREFIX=/usr/local/mysql \
        -DDEFAULT_CHARSET=utf8mb4 \
        -DDEFAULT_COLLATION=utf8mb4_general_ci \
        -DMYSQL_DATADIR=/var/mysql \
        -DSYSCONFDIR=/usr/local/mysql/etc \
        -DWITH_INNOBASE_STORAGE_ENGINE=1 \
        .. \
    \
    && make \
    && make install \
    && make clean \
    \
    && cd "${MYSQL_HOME}" \
    && rm -rf /usr/src/* \
    && rm -rf "${MYSQL_HOME}/mysql-test" \
    \
    && chown -R mysql:mysql /usr/local/mysql \
    \
    && mkdir -p "${MYSQL_CONF_PATH}" \
    && mkdir -p "${MYSQL_CONF_PATH}/conf.d" \
    && { \
           echo "!includedir ${MYSQL_CONF_PATH}/mysql.conf.d/"; \
           echo "!includedir ${MYSQL_CONF_PATH}/conf.d/"; \
       } >> "${MYSQL_CONF_PATH}/my.cnf" \
    \
    && mkdir -p "${MYSQL_CONF_PATH}/mysql.conf.d" \
    && { \
           echo "[mysqld]"; \
           echo "skip-host-cache"; \
           echo "skip-name-resolve"; \
           echo "datadir = /var/mysql"; \
           echo "symbolic-links = 0"; \
           echo ; \
           echo "[mysqldump]"; \
           echo "quick"; \
           echo "quote-names"; \
           echo "max_allowed_packet	= 16M"; \
           echo ; \
       } >> "${MYSQL_CONF_PATH}/mysql.conf.d/docker.cnf" \
    \
    && rm -rf ${MYSQL_HOME}/bin/*test* \
    \
    && { find . -type f -exec strip --strip-all {} + || true; } \
    \
    && MYSQL_RUNTIME_DEPS="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/mysql \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
       )" \
    && apk add --virtual .mysql-runtime-deps "${MYSQL_RUNTIME_DEPS}" \
    && apk del .build-deps \
    \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

COPY mysql-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/mysql-entrypoint.sh
ENTRYPOINT ["/usr/local/bin/mysql-entrypoint.sh"]

ENV PATH $MYSQL_HOME/bin:$PATH
WORKDIR /var/mysql
EXPOSE 3306
CMD ["mysql-daemon"]
