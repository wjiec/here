#!/bin/sh

# path of redis configure file
REDIS_CONF_PATH=/usr/local/redis/etc/redis.conf

# check redis configure exists
if [[ -f ${REDIS_CONF_PATH} ]]; then
    redis-server ${REDIS_CONF_PATH};
else
    redis-server
fi;
