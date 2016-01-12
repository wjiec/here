"use strict";

(function($) {
/**
 * @author ShadowMan
 * @create 1.11.2016
 */
const VERSION = '0.0.1/16.1.11'

$.support.pjax    = window.history && window.history.pushState && window.history.replaceState && !navigator.userAgent.match(/((iPod|iPhone|iPad).+\bOS\s+[1-4]\D|WebApps\/.+CFNetwork)/)
$.support.storage = !!window.localStorage

function realUrl(url) {
    return (url || '').replace(/#.*$/, '')
}

function getHash(url) {
    return (url || '').replace(/^[^#]*(?:#(.*))?$/, '$1')
}

function entry(selector, container, options) {
    
}

function enable() {
    $.fn.pjax = entry
}

if ($.event.props && $.inArray('state', $.event.props) < 0) {
    $.event.props.push('state')
}

function disable() {
    $.fn.pjax = function() { return this }
}

$.support.pjax ? enable() : disable()

})(typeof jQuery == 'function' ? jQuery : Zepto)

