#!/bin/sh

# path of redis configure file
redis_conf_path=/usr/local/redis/etc/redis.conf

# check redis configure exists
if [ -f $redis_conf_path ]; then
    redis-server $redis_conf_path;
else
    redis-server
fi;
