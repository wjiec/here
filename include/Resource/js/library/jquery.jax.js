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
var globalState = null
var lastXHR = null
var defaultOptions = {
    timeout: 650,
    push: true,
    replace: false,
    type: 'GET',
    dataType: 'HTML',
    scrollTo: null,
    fullReplace: false,
    urlReplace: true
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

function parseHTML(html) {
    return $.parseHTML(html, document, true)
}

function filter(el, selector) {
    return el.filter(selector).add(el.find(selector))
}

function extractContainer(data, xhr, options) {
    var obj = {}
    var fullDocument = /<html/i.test(data)

    obj.url = options.url
    if (fullDocument) {
        var head = $(parseHTML(data.match(/<head[^>]*>([\s\S]*)<\/head>/i)[0]))
        var body = $(parseHTML(data.match(/<body[^>]*>([\s\S]*)<\/body>/i)[0]))
    } else {
        var head, body
        head = body = $(parseHTML(data))
    }
    
    if (body.length == 0) {
        return obj
    }

    var selector = options.container.selector
    obj.contents = filter(body, selector).first().text()
    if (options.fullReplace) {
        obj.contents = data
    }

    obj.title = $.trim(filter(head, 'title').last().text())

    return obj
}

function unixStamp() {
    return int((new Date).getTime())
}

function entry(selector, container, options) {
    var context = this

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
    if (el.tagName.toUpperCase() !== 'A' && el.tagName.toUpperCase() !== 'BUTTON') {
        throw 'require an anchor element'
    }

    if (el.tagName.toUpperCase() === 'BUTTON') { // Replace el
        el = document.createElement('a')

        if (options.url) {
            el.href = options.url
        }
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

    function trigger(type, args, props) {
        if (!props) { props = {} }
        props.relatedElement = el

        var e = $.Event(type, props)
        context.trigger(e, args)

        return !e.isDefaultPrevented()
    }

    var timeoutTimer = null
    /**
     * brforeSend Member
     */
    options.beforeSend = function(xhr, settings) {
        if (settings.type.toUpperCase() !== 'GET') {
            settings.timeout = 0
        }

        xhr.setRequestHeader('JAX', true)
        xhr.setRequestHeader('JAX-Container', context.selector)

        if (!trigger('jax:beforeSend', [xhr, settings])) {
            return false
        }

        if (settings.timeout > 0) {
            timeoutTimer = setTimeout(function() {
                if (trigger('jax:timeout', [xhr, settings])) {
                    xhr.abort('timeout')
                }
            }, settings.timeout)
            settings.timeout = 0
        }
    }
    /**
     * Complete 
     */
    options.complete = function(xhr, textStatus) {
        if (timeoutTimer) {
            clearTimeout(timeoutTimer)
        }
        trigger('jax:complete', [xhr, textStatus, options])
    }
    /**
     * Error Handle
     */
    options.error = function(xhr, textStatus, errorThrown) {
        var allowed = trigger('jax:error', [xhr, textStatus, errorThrown, options])
        if (options.type.toUpperCase() == 'GET' && textStatus !== 'abort' && allowed) {
            var contents = extractContainer("", xhr, options)
            // hard reload ?
        }
    }
    /**
     * Success
     */
    options.success = function(data, status, xhr) {
        var responsed = extractContainer(data, xhr, options)
        var prevState = globalState

        globalState = {
            id: unixStamp(),
            url: responsed.url,
            title: responsed.title,
            container: options.container.selector,
            timeout: options.timeout,
            full: {
                document: /<html/i.test(data),
                replace: options.fullReplace,
                base: location.href
            }
        }

        window.history.replaceState(globalState, responsed.title, options.urlReplace ? responsed.url : null)
        if ($.contains(options.container, document.activeElement)) {
            try {
                document.activeElement.blur()
            } catch (e) {}
        }
        
        if (responsed.title) {
            document.title = responsed.title
        }
        
        trigger('jax:beforeReplace', [responsed.contents, options], {
            state: globalState,
            prevState: prevState
        })
        context.html(responsed.contents)
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

