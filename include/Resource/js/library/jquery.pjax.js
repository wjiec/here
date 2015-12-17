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
})(typeof jQuery == 'function' ? jQuery : Zepto);

