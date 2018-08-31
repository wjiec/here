# minial install node with yarn
FROM alpine:3.6

# author info
MAINTAINER Wang <shadowman@shellboot.com>

# China mirrors
RUN set -x \
    && country=`wget -T1 -q -O- google.com 2>&1 | sed -nr 's/.*(timed\ out).*/China/p'` \
    && if [ "$country" == "China" ]; then \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/main' > /etc/apk/repositories; \
           echo 'http://mirrors.ustc.edu.cn/alpine/v3.6/community' >> /etc/apk/repositories; \
       fi;

# environment for node and yarn
ENV NODE_VERSION 8.11.4
ENV YARN_VERSION latest

# generic named for home folder
ENV NODE_HOME /usr/local/node
ENV YARN_HOME /usr/local/yarn

# install deps and fetch/compile/install node/yarn
RUN set -x \
    && apk update \
    && apk add --virtual .build-deps \
        binutils-gold \
        curl \
        curl-dev \
        gcc \
        g++ \
        libstdc++ \
        linux-headers \
        make \
        python \
    \
    && curl -SL "https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}.tar.xz" -o node.tar.xz \
    && curl -SL "https://yarnpkg.com/${YARN_VERSION}.tar.gz" -o yarn.tar.gz \
    \
    && mkdir -p "/usr/src" \
    \
    && tar xvf node.tar.xz -C /usr/src \
    && tar xvf yarn.tar.gz -C /usr/src \
    && rm -rf node.tar* \
    && rm -rf yarn.tar* \
    \
    && mkdir -p "$NODE_HOME" \
    && mkdir -p "$YARN_HOME" \
    \
    && cp -r "$(ls -d /usr/src/yarn*)/." "$YARN_HOME" \
    \
    && cd "/usr/src/node-v$NODE_VERSION" \
    && ./configure \
        --prefix="$NODE_HOME" \
        \
        --without-npm \
    \
    && make -j "$(getconf _NPROCESSORS_ONLN)" \
    && make install \
    \
    && cd "$NODE_HOME" \
    && rm -rf /usr/src/* \
    \
    && { find . -type f -perm +0111 -exec strip --strip-all {} + || true; } \
    \
    && nodeRuntimeDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive $NODE_HOME \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )" \
    && apk add --virtual .node-runtime-deps $nodeRuntimeDeps \
    && apk del .build-deps \
    \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/* \
    && rm -rf /usr/share/man \
    && rm -rf /root/.npm /root/.node-gyp /root/.gnupg \
    && rm -rf /usr/lib/node_modules/npm/man \
    && rm -rf /usr/lib/node_modules/npm/doc \
    && rm -rf /usr/lib/node_modules/npm/html \
    && rm -rf /usr/lib/node_modules/npm/scripts

# set executeable path
ENV PATH $NODE_HOME/bin:$YARN_HOME/bin:$PATH
