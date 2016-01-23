"use strict";

(function($) {
/**
 * @author ShadowMan
 * @create 1.11.2016
 */
const VERSION = '0.0.1/16.1.11'

$.support.pjax = window.history && window.history.pushState && window.history.replaceState && !navigator.userAgent.match(/((iPod|iPhone|iPad).+\bOS\s+[1-4]\D|WebApps\/.+CFNetwork)/)
$.support.storage = !!window.localStorage

var stack = []
var lastXHR = null
var defaultOptions = {
    timeout: 650,
    push: true,
    replace: false,
    type: 'GET',
    dataType: 'HTML',
    scrollTo: null,
    fullReplace: false
}

function d(msg) {
    return console.log(msg)
}

function protocol(url) {
    return (typeof url === 'string') ? ((url.match(/^https:|http:/)) ? (url.match(/^https|http/))[0] : 'http') : null
}

function hostname(url) {
    return (url || '').replace(/#.*$/, '')
}

function hash(url) {
    return (url || '').replace(/^[^#]*(?:#(.*))?$/, '$1')
}

function int(val) {
    return isNaN(parseInt(val)) ? null : parseInt(val);
}

function optionsFor(container, options) {
    if (container && options) {
        options.container = container
    } else if ($.isPlainObject(container)) {
        options = container
    } else {
        options = { container: container }
    }

    if (options.container) {
        options.container = findContainerFor(options.container)
    }

    return options
}

function findContainerFor(container) {
    container = $(container)

    /**
     * $(window).selector => ""
     * $(document).selector => "" && $(document).context => document
     */
    if (!container.length) {
        throw 'no jax container for ' + container.selector
    } else if (container.selector !== '' && container.context === document) {
        return container
    } else if (container.attr('id')) {
        return $('#' + container.attr('id'))
    } else {
        throw 'cant get selector for pjax container'
    }
}

function stripHash(location) {
    return location.href.replace(/#.*/, '')
}

function entry(selector, container, options) {
    var context = this
    var a = 1

    return this.on('click.jax', selector, function(event) { // this => dom obj
        var opts = $.extend({}, optionsFor(container, options))
        if (!opts.container) {
            opts.container = $(this).attr(CONTAINER) || context
        }
        handleClick(event, opts)
    })
}

function handleClick(event, container, options) {
    options = optionsFor(container, options)

    var el = event.currentTarget
    if (el.tagName.toUpperCase() !== 'A') {
        throw 'require an anchor element'
    }

    if (event.which > 1 || event.ctrlKey || event.altKey || event.shiftKey) {
        return
    }
    if (location.protocol !== el.protocol || location.hostname !== el.hostname) {
        return
    }
    if (el.href.indexOf('#') != -1 && stripHash(el) === stripHash(location)) {
        return
    }
    if (event.isDefaultPrevented()) {
        return
    }

    var defaults = {
        url: el.href,
        container: $(this).attr('data-jax-container'),
        element: el
    }
    var opts = $.extend({}, defaults, options)

    var clickEvent = $.Event('jax:click')
    $(el).trigger(clickEvent, [opts])

    if (!clickEvent.isDefaultPrevented()) {
        jax(opts)
    }
}

function jax(options) {
    options = $.extend(true, {}, $.ajaxSettings, defaultOptions, options)
    
    if ($.isFunction(options.url)) {
        options.url = options.url()
    }

    var el = options.element
    var hh = hash(options.url)
    var context = options.context = findContainerFor(options.container)

    function eventTrigger(type, args, props) {
        if (!props) { props = {} }
        props.relatedTarget = el

        var e = $.Event(type, props)
        context.trigger(e, args)

        return !e.isDefaultPrevented()
    }

    var timeoutTimer = null
    options.beforeSend = function(xhr, settings) {
        if (settings.type.toUpperCase() !== 'GET') {
            settings.timeout = 0
        }

        xhr.setRequestHeader('JAX', true)
        xhr.setRequestHeader('JAX-Container', context.selector)

        if (!eventTrigger('jax:beforeSend', [xhr, settings])) {
            return false
        }

        if (setting.timeout) {
            timeoutTimer = setTimeout(function() {
                if (eventTrigger('jax:timeout', [xhr, settings])) {
                    xhr.abort('timeout')
                }
            }, settings.Timeout)

            settings.timeout = 0
        }
    }

    options.complete = function(xhr, textStatus) {
    }

    options.error = function(xhr, textStatus, errorThrown) {
    }

    options.success = function(data, status, xhr) {
    }
    
    lastXHR = $.ajax(options)
}

function enable() {
    $.fn.jax = entry
}

function disable() {
    $.fn.pjax = function() { return this }
}

if ($.event.props && $.inArray('state', $.event.props) < 0) {
    $.event.props.push('state')
}

$.support.pjax ? enable() : disable()

})(typeof jQuery == 'function' ? jQuery : Zepto)

