/* Base Module */

export default class $ {
    // HereJavascriptFramework Constructor
    constructor(selector) {
        // initializing selector
        if (selector === document) {
            this._selector = selector
        } else if ($.is_string(selector)) {
            this._selector = document.querySelectorAll(selector)

            if (this._selector === null) {
                throw new Error(`selector ('${selector}') not found`)
            }
        } else {
            throw Error('Selector invalid')
        }
        // chaining-call
        return this
    }

    on(event_name, event_callback, use_capture = false) {
        // check event name and callback is correct
        if (!$.is_string(event_name) || !$.is_function(event_callback)) {
            throw Error('event name or callback invalid')
        }
        // trim 'on'
        if (event_name.indexOf('on') === 0) {
            event_name = event_name.substr(2)
        }
        // foreach all node
        if (this._selector === document) {
            // only this way? addEventListener is invalid
            document[`on${event_name}`] = event_callback
        } else {
            // add event listener
            [].forEach.call(this._selector, (selector) => {
                selector.addEventListener(event_name, event_callback, use_capture)
            })
        }
        // chaining-call
        return this
    }

    unbind(event_name, event_callback) {
        // check event name and callback is correct
        if (!$.is_string(event_name) || !$.is_function(event_callback)) {
            throw Error('event name or callback invalid')
        }
        // trim 'on'
        if (event_name.indexOf('on') === 0) {
            event_name = event_name.substr(2)
        }
        // foreach all node
        [].forEach.call(this._selector, (selector) => {
            selector.removeEventListener(event_name, event_callback)
        })
    }
    // utility method
    static ready(ready_callback) {
        if ($.is_function(ready_callback)) {
            document.addEventListener('DOMContentLoaded', ready_callback, true)
        } else {
            throw Error('ready_callback is not function')
        }
    }
    // internal method
    static is_function(object) {
        return typeof object === 'function'
    }
    // internal method
    static is_string(object) {
        return typeof object === 'string'
    }
}

// export to global
window.$ = $
