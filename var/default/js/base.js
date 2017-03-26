"use strict";

(function( global, factory ) {
    if ( typeof module === "object" && typeof module.exports === "object" ) {
        module.exports = global.document ?
            factory( global, true ) :
            function( w ) {
                if ( !w.document ) {
                    throw new Error( "Frame requires a window with a document" );
                }
                return factory( w );
            };
    } else {
        factory( global );
    }

// Pass this if window is not defined yet
})(typeof window !== "undefined" ? window : this, function( window, no_global ) {
    var document = window.document

    // selector
    var _ = function(selector, context) {
        if (selector === null || selector === document) {
            _.target = document
        } else {
            _.target = document.querySelector(selector)
        }

        return _
    }

    // current element
    _.target = null

    // bind event method
    _.on = function(event, handler, selector = null) {
        selector = _(selector).target || _.target

        if (typeof event === 'string') {
            if (event.indexOf('on') === 0) {
                event = event.substr(2) // trim 'on'
            }

            if (selector === document) {
                selector[('on' + event)] = handler;
            }
        }
        selector.addEventListener(event, handler, true)
        return _
    }

    // utils method
    _.ready = function(handler) {
        document.addEventListener('DOMContentLoaded', handler, true)
    }

    // export interface
    window.$ = _
})
