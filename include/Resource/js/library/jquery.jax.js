"use strict";
/**
 * Event List:
 *      jax:click
 *      jax:beforeSend
 *      jax:complete jax:timeout jax:error jax:success
 *      jax:beforeReplace
 */
(function($) {
/**
 * @author ShadowMan
 * @create 1.11.2016
 */
const VERSION = '0.0.1/16.1.11'

$.support.pjax = window.history && window.history.pushState && window.history.replaceState && !navigator.userAgent.match(/((iPod|iPhone|iPad).+\bOS\s+[1-4]\D|WebApps\/.+CFNetwork)/)
$.support.storage = !!window.localStorage

function d(msg) {
    return console.log(msg)
}

function protocol(url) {
    return (typeof url === 'string') ? ((url.match(/^https:|http:/)) ? (url.match(/^https|http/))[0] : 'http') : null
}

function hostname(url) {
    return (url || '').replace(/#.*$/, '')
}

function search(url) {
    return /\?([^#]*)/.test(url) ? url.match(/\?([^#]*)/)[0] : null
}

function hash(url) {
    return (url || '').replace(/^[^#]*(?:#(.*))?$/, '$1')
}

function parseUrl(href, search, hash) {
    var u = href + '?'
    if (typeof search == 'object') {
        for (var k in search) {
            u += (k + '=' + search[k])
        }
    }
    u += hash ? hash.indexOf('#') ? hash : ('#' + hash) : ''

    return u
}

function int(val) {
    return isNaN(parseInt(val)) ? null : parseInt(val);
}

function getItemValue(el, key) {
    return el.attributes.getNamedItem(key).value
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
    var obj = {}, fullDocument = /<html/i.test(data)

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
    if (options.fullReplace && !fullDocument) {
        obj.contents = $(parseHTML(data))
    }

    obj.title = $.trim(filter(head, 'title').last().text())
    if (obj.contents) {
        obj.scripts = filter(obj.contents, 'script[src]').remove()
        obj.contents = obj.contents.not(obj.scripts)
    }

    return obj
}

function unixStamp() {
    return int((new Date).getTime())
}

function abort(xhr) {
    if (xhr && xhr.readyState < 4) {
        xhr.onreadystatechange = $.noop
        xhr.abort()
    }
}

function entry(selector, container, options) {
    var context = this

    return this.on('click.jax', selector, function(event) { // this => dom obj
        var opts = $.extend({}, optionsFor(container, options))
        if (!opts.container) {
            opts.container = context
        }
        handleClick(event, opts)
    })
}

function handleClick(event, container, options) {
    options = optionsFor(container, options)

    var context, el = event.currentTarget
    if (el.tagName.toUpperCase() !== 'A' && el.tagName.toUpperCase() !== 'BUTTON') {
        throw 'require an anchor element or a button element'
    }

    if (el.tagName.toUpperCase() === 'BUTTON') { // button convert a
        context = el
        el = document.createElement('a')
        if ($(context).attr('data-jax-url')) {
            el.href = $(context).attr('data-jax-url')
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

    var data = {}
    try { data = JSON.parse($(context).attr('data-jax-data')) }
    catch (e) { throw 'Data {' + $(context).attr('data-jax-data') + '} Syntal Error' }
    var opts = $.extend({}, {
//        url: el.href,
        url: parseUrl(el.href, data),
        container: $(context).attr('data-jax-container'),
        element: context,
        data: data
    }, options)

    var clickEvent = $.Event('jax:click')
    $(context).trigger(clickEvent, [opts])

    if (!clickEvent.isDefaultPrevented()) {
        jax(opts)
    }
}

var jaxNS = {}
var stack = []
var globalState = null
var lastXHR = null
var defaultOptions = {
    timeout: 650,
    push: true,
    type: 'GET',
    dataType: 'HTML',
    scrollTo: null,
    cache: true, // stack && localStorage
    fullReplace: false,
    urlReplace: null, // search hash
}

function jax(options) {
    options = $.extend(true, {}, $.ajaxSettings, defaultOptions, options)

    if ($.isFunction(options.url)) {
        options.url = options.url()
    }

    var el = options.element
    var hh = hash(options.url)
    var container = findContainerFor(options.container)
    var context = options.context = findContainerFor(options.container) // XXX: options.context ?

    function trigger(type, args, props) {
        if (!props) { props = {} }
        props.relatedElement = el

        var e = $.Event(type, props)
        container.trigger(e, args)

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
        xhr.setRequestHeader('JAX-Container', container.selector)

        if (!trigger('jax:beforeSend', [xhr, settings])) {
            return false // isDefaultPrevented
        }

        if (settings.timeout > 0) {
            // take over
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

        if (!responsed.contents) {
            trigger('jax:empty', [data, xhr])
            // return
        }

        globalState = {
            id: unixStamp(),
            url: responsed.url,
            title: responsed.title,
            container: options.container.selector,
            timeout: options.timeout,
            fullReplace: options.fullReplace
        }
        if (options.fullReplace && !(/<html/i.test(data))) {
            globalState.full = {
                document: false,
                base: location.href
            }
        }

        jaxNS.search = search, jaxNS.hash = hash
        window.history.pushState(globalState, responsed.title, options.urlReplace ? jaxNS[options.urlReplace](options.url) : null)
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

        trigger('jax:cache', [responsed, globalState, options])
        if (options.cache) {
            stack[globalState.id] = {
                id: globalState.id,
                contents: responsed.contents,
                container: globalState.container,
                fullReplace: options.fullReplace,
                full: globalState.full
            }
        }

        d(stack)
        
        trigger('jax:success', [data, status, xhr, options]);
    }

    abort(lastXHR)
    lastXHR = $.ajax(options)

    return lastXHR
}

function popstateEntry(event) {
    abort(lastXHR)

    var direction = null
    var prevState = globalState
    var currentState = event.state
    if (currentState && currentState.container) {
        if (prevState) {
            if (prevState.id == currentState.id) {
                return
            }
            direction = prevState.id > currentState.id ? 'forward' : 'back'
        }

        var cache = stack[currentState.id] || {}
        var container = $(cache.container || currentState.container)
        var contents = cache.contents
        var popstateEvent = $.Event('jax:popstate', {
            state: currentState,
            direction: direction
        })
        container.trigger(popstateEvent)
    }
}

function enable() {
    $.fn.jax = entry
    
    $(window).on('popstate.jax', popstateEntry)
}

function disable() {
    $.fn.pjax = function() { return this }
}

if ($.event.props && $.inArray('state', $.event.props) < 0) {
    $.event.props.push('state')
}

$.support.pjax ? enable() : disable()

})(typeof jQuery == 'function' ? jQuery : Zepto)

