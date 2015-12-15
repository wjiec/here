"use strict";

(function($) {
    var util = {
        support: {
            pjax: !!window.history && !!window.history.pushState && !!window.history.replaceState,
            storage: !!window.localStorage
        },
        getRealURL: function(url) { return (url || '').replace(/\#.*?$/, ''); },
        getHash: function(url) { return url.replace(/^[^\#]*(?:\#(.*?))?$/, '$1'); }
    }
    var pjax = function(options) {
        options = $.extend({
            selector: null,
            container: null,
            filter: null,
            callback: null
        }, options || {});

        if (!options.selector || !options.container) {
            throw new Error('Selector and Container must be set');
        }

        $(document).delegate(options.selector, 'click', function(event) {
            var href = $(this).prop('href') ? $(this).prop('href') : $(this).attr('href');

            if (typeof options.filter === 'function') { options.filter.call(this, href); }
            if (location.href === href) { return true; }
            if (util.getRealURL(location.href) === util.getRealURL(href)) {
                var hash = util.getHash(href);
                if (hash) { location.hash = hash; }
                return true;
            }

            event.preventDefault();
            options = $.extend({}, options, {
                url : href,
                element : this,
                title: '',
            });
            pjax.request(options);
        });
    }
    pjax.options = {};
    pjax.state = {};
    pjax.defaultOptions = {
        url: null,
        type: 'GET',
        data: {},
        dataType: 'html',
        beforeSend : function(xhr) {
            $(pjax.options.container).trigger('pjax.start', [ xhr, pjax.options ]);
            xhr && xhr.setRequestHeader('X-REQUEST', 'PJAX');
        }
    }
    pjax.success = function(options) {
        pjax.state = {
            container: pjax.options.container,
            title: document.title,
            url: pjax.options.url
        };
        history.pushState(pjax.state, document.title, pjax.options.url);
    }
    pjax.xhr = null;
    pjax.request = function(options) {
        var cache = null;
        var container = $(options.container);
        
        options = $.extend({}, pjax.defaultOptions, options);
        options.beforeSend();
        pjax.options = options;
        pjax.options.success = pjax.success;
        pjax.xhr = $.ajax(pjax.options);
        console.log(options);
    }
    
    $(window).on('popstate', function(event) {
        
    });
    
    if (!util.support.pjax) { pjax = $.noop; }
    if (!util.support.storage) { storage = $.noop; }
    $.pjax = pjax; $.pjax.util = util;
})(typeof jQuery == 'function' ? jQuery : Zepto);

