"use strict";
/**
 * @author ShadowMan
 * @create 1/11 2016
 * @version 1.0.0/16.1.1
 * 
 * Event List:
 *      jax:start
 *      jax:click
 *      jax:beforeSend
 *      jax:complete jax:timeout jax:error jax:success
 *      jax:beforeReplace
 *      jax:cache
 *      jax:success
 */
(function(window) {
// document reference
var document = window.document

var _is_support = function() {
    return _is_support.ua && _is_support.history && _is_support.storage
}

_is_support.ua = !navigator.userAgent.match(/((iPod|iPhone|iPad).+\bOS\s+[1-4]\D|WebApps\/.+CFNetwork)/)
_is_support.history = window.history && window.history.pushState && window.history.replaceState
_is_support.storage = !!window.localStorage

function url_protocol(url) {
    return (typeof url === 'string') ? ((url.match(/^https:|http:/)) ? (url.match(/^https|http/))[0] : 'http') : null
}

function url_trim_hash(url) {
    return (url || '').replace(/#.*$/, '')
}

function url_params(url) {
    return /\?([^#]*)/.test(url) ? url.match(/\?([^#]*)/)[0] : null
}

function url_hash(url) {
    return (url || '').replace(/^[^#]*(?:#(.*))?$/, '$1')
}

function assemble_url(url, params, hash) {
    var _complete_url = url = '?'

    for (var k in typeof params === 'object' ? params : Object() ) {
        _complete_url += (k + '=' + params[k])
    }

    _complete_url += hash ? hash.indexOf('#') ? hash : ('#' + hash) : ''
    return _complete_url
}

function int(val) {
    return isNaN(parseInt(val)) ? null : parseInt(val);
}

function get_element_attr(el, attr) {
    return el.attributes.getNamedItem(attr).value
}



})(window)
