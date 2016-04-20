"use strict";
/**
 * Event List:
 *      jax:start
 *      jax:click
 *      jax:beforeSend
 *      jax:complete jax:timeout jax:error jax:success
 *      jax:beforeReplace
 *      jax:cache
 *      jax:success
 */
(function($) {
/**
 * @author ShadowMan
 * @create 1/11 2016
 * @version 1.0.0/16.1.1
 */

$.support.pjax = window.history && window.history.pushState && window.history.replaceState && !navigator.userAgent.match(/((iPod|iPhone|iPad).+\bOS\s+[1-4]\D|WebApps\/.+CFNetwork)/)
$.support.storage = !!window.localStorage

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
        if (!options.container) {
            options.container = container
        }
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
    } else if (container.selector !== '' && ((container.context === document) || ($ === Zepto && container.context == undefined))) {
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
    var rsingleTag = (/^<(\w+)\s*\/?>(?:<\/\1>|)$/)

    if (!html && typeof html !== 'string') {
        return null;
    }

    var parsed = /^<(\w+)\s*\/?>(?:<\/\1>|)$/.exec(html)
    if (parsed) {
        return [ document.createElement(parsed[1]) ]
    } else {
        var fragment = document.createDocumentFragment()
        var node = document.createElement('div')
        var item

        node.innerHTML = html
        while (item = node.firstChild) {
            fragment.appendChild(item)
        }
        return fragment
    }
}

function filter(el, selector) {
    return el.filter(selector).add(el.find(selector))
}

function localClean() {
    var currentDate = unixStamp()

    for (var d in localStorage) {
        if (int(d / 1000) + 15 * 24 * 3600 * 1000 < int(currentDate / 1000)) {
            localStorage.removeItem(d)
        }
    }
}
localClean()

function localPush(stackNode, timeout) {
    localStorage.setItem(stackNode.id, stackNode)
}

function extractContainer(data, xhr, options) {
    if (typeof data == 'object') {
        data = data.data
    }
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
        obj.scripts = filter(obj.contents, 'script').remove()
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

        var jaxEvent = $.Event('jax:jax')
        $(opts.container).trigger(jaxEvent, [opts])
        handleClick(event, opts)
        if (opts.callback != undefined) {
            opts.callback.call(this)
        }
    })
}

var lastXHR = null
function handleClick(event, container, options) {
    options = optionsFor(container, options)

    var context, el = event.currentTarget, context = el
    if (el.tagName.toUpperCase() !== 'A' && el.tagName.toUpperCase() !== 'BUTTON') {
        throw 'require an anchor or button element'
    }

    if (el.tagName.toUpperCase() == 'BUTTON') { // button convert a
        el = document.createElement('a')
        el.href = options.url ? options.url : $(context).attr('data-jax-url')
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
    if ($(context).attr('data-jax') == 'disabled' || $(context).attr('data-disabled-jax') != undefined) {
        return
    }

    options.data = (typeof options.data == 'function') ? options.data() : {}
    context = $(context)
    var opts = $.extend({}, {
        url: el.href,
        element: context,
        callback: null
    }, options)

    var clickEvent = $.Event('jax:click')
    $(context).trigger(clickEvent, [opts])

    if (!clickEvent.isDefaultPrevented()) {
        lastXHR = jax(opts)
    }
}

var jaxNS = {}
var stack = []
var globalState = null
var defaultOptions = {
    timeout: 650,
    type: 'GET',
    dataType: 'HTML',
    localStorage: true,
    fullReplace: false,
    urlReplace: null, // search hash
}
function jax(options) {
    options = $.extend(true, {}, $.ajaxSettings, defaultOptions, options)

    var el = options.element
    var hh = hash(options.url)
    var container = findContainerFor(options.container)

    function trigger(type, args, props) {
        if (!props) {
            props = {}
        }
        props.element = el

        var e = $.Event(type, props)
        container.trigger(e, args)

        return !e.isDefaultPrevented() // true => continue, false => abort
    }

    var timeoutTimer = null
    options.beforeSend = function(xhr, settings) {
        if (settings.type && settings.type.toUpperCase() !== 'GET') {
            settings.timeout = 0
        }

        xhr.setRequestHeader('JAX', true)
        xhr.setRequestHeader('JAX-Container', container.selector)

        if (!trigger('jax:beforeSend', [xhr, settings])) {
            return false // isDefaultPrevented
        }

        if (settings.timeout > 0) {
            timeoutTimer = setTimeout(function() {
                if (!trigger('jax:timeout', [xhr, settings])) {
                    xhr.abort('timeout')
                }
            }, settings.timeout)
            settings.timeout = 0
        }
    }
    options.complete = function(xhr, textStatus) {
        if (timeoutTimer) {
            clearTimeout(timeoutTimer)
        }
        trigger('jax:complete', [xhr, textStatus, options])
    }
    options.error = function(xhr, textStatus, errorThrown) {
        var allowed = trigger('jax:error', [xhr, textStatus, errorThrown, options])
        if (options.type && options.type.toUpperCase() == 'GET' && textStatus !== 'abort' && allowed) {
            var contents = extractContainer("", xhr, options)
            // hard reload ?
        }
    }
    // XXX Run Script && reset CSS ...
    options.success = function(data, status, xhr) {
        var responsed = extractContainer(data, xhr, options)
        var prevState = globalState

        if (!responsed.contents) {
            trigger('jax:empty', [data, xhr])
            return false
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
        window.history.pushState(globalState, null, options.urlReplace ? jaxNS[options.urlReplace](options.url) : null)
        if (responsed.title) {
            document.title = responsed.title
        }

        trigger('jax:beforeReplace', [data, options, responsed.contents], {
            state: globalState,
            prevState: prevState
        })
        container.html(responsed.contents)

        trigger('jax:cache', [responsed, globalState, options])
        if (options.localStorage) {
            stack[globalState.id] = $.extend({
                contents: responsed.contents
            }, globalState)
            localPush(stack[globalState.id])
        }

        trigger('jax:success', [data, status, xhr, options])
    }

    abort(lastXHR)
    return $.ajax(options)
}

// XXX: initial pop -> event.state => null
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

        var options = {
            url: currentState.url,
            container: currentState.container,
            push: false,
            timeout: currentState.timeout,
            fullReplace: currentState.fullReplace
        }

        if (contents) {
            if (currentState.title) {
                document.title = currentState.title
            }

            var beforeReplaceEvent = $.Event('jax:beforeReplace', {
                state: currentState
            })
            container.trigger(beforeReplaceEvent, [contents])
            container.html(contents)

            container.trigger('jax:replaceEnd')
        } else {
            jax(options)
        }
    }
}

function enable() {
    $.extend($.fn, {
        jax: entry
    })
    $(window).on('popstate.jax', popstateEntry)
}

function disable() {
    $.extend($.fn, {
        jax: $.noop
    })
}

if ($.event.props && $.inArray('state', $.event.props) < 0) {
    $.event.props.push('state')
}

$.support.pjax ? enable() : disable()

})(typeof jQuery === 'function' ? jQuery : Zepto);
