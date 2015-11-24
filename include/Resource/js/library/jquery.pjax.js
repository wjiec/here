"use strict";

(function($) {
    const util = {
        support: {
            pjax: window.history && window.history.pushState && window.history.replaceState && !navigator.userAgent.match(/(iPod|iPhone|iPad|WebApps\/.+CFNetwork)/),
            storage: !!window.localStorage
        }
    }
    
    var pjax = function(options) {
        var options = $.extend({
            selector: '',
            container: '',
            callback: $.noop,
            filter: $.noop
        }, options || {});
    }
    
    if (!util.support.pjax) {
        pjax = function() {
            return true;
        }
        pjax.request = function(options) {
            if (options && options.url) {
                location.href = options.url;
            }
        }
    }
    
    $.pjax = pjax;
    
    if ($.inArray('state', $.event.props) < 0) {
        $.event.props.push('state');
    }
})(jQuery);
