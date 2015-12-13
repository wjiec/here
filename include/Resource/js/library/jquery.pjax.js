"use strict";

(function($) {
    var util = {
        support: {
            pjax: !!window.history && !!window.history.pushState && !!window.history.replaceState,
            storage: !!window.localStorage
        },
        getReal: function(url) {
            return (url || '').replace(/\#.*?$/, '');
        },
        getHash: function(url) {
            return url.replace(/^[^\#]*(?:\#(.*?))?$/, '$1');
        }
    }
    var pjax = function(options) {
        options = $.extend({
            selector: null,
            container: null,
            filter: null
        }, options || {});
        
        if (!options.selector || !options.container) {
            throw new Error('Selector and Container must be set');
        }
        
        $(document).delegate(options.selector, 'click', function(event) {
            var href = $(this).prop('href') ? $(this).prop('href') : $(this).attr('href');
            
            if (typeof options.filter === 'function') {
                options.filter.call(this, href);
            }
            if (location.href === href) {
                return true;
            }
            if (util.getReal(location.href) === util.getReal(href)) {
                var hash = util.getHash(href);
                if (hash) {
                    location.hash = hash;
                }
                return true;
            }
            
            event.preventDefault();
            options = $.extend({}, options, {
                url : href,
                element : this,
                title: '',
                push: true
            });
            pjax.request(options);
        });
    }
    pjax.request = function(options) {
        console.log(options);
    }
    var storage = function() {
        
    }
    if (!util.support.pjax) {
        pjax = $.noop;
    }
    if (!util.support.storage) {
        storage = $.noop;
    }
    
    $.pjax = pjax;
    $.pjax.util = util;
})(typeof jQuery == 'function' ? jQuery : Zepto);

