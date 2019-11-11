#!/usr/bin/env bash

WORKSPACE="$(readlink -f "$(dirname "${0}")")"

CACHE_STORAGE="${WORKSPACE}/storage/cache"
if [[ -d "${CACHE_STORAGE}" ]]; then
    chmod -R 777 "${CACHE_STORAGE}"
fi

LOG_STORAGE="${WORKSPACE}/storage/log"
if [[ -d "${LOG_STORAGE}" ]]; then
    chmod -R 777 "${LOG_STORAGE}"
fi

NGINX_CONF_DIR="${WORKSPACE}/docs/conf/nginx"
NGINX_VHOST_FILE="${NGINX_CONF_DIR}/vhost/here.conf.http"
if [[ -f "${NGINX_CONF_DIR}/ssl/server.crt" && -f "${NGINX_CONF_DIR}/ssl/server.key" ]]; then
    NGINX_VHOST_FILE="${NGINX_CONF_DIR}/vhost/here.conf.https"
fi
cp "${NGINX_VHOST_FILE}" "${NGINX_CONF_DIR}/vhost/here.conf"
