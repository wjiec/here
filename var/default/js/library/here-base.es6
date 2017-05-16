import {AjaxAdapter, WebSocketAdapter} from './communication.es6'
import {History} from './history.es6'
import {Utility} from './utils.es6'

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
    }
    // event bind method
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
    // unbind event
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
    // getting dom object
    get element() {
        if (this._selector.length === 1) {
            return this._selector[0];
        }
        return this._selector;
    }
    // ajax adapter
    static get AjaxAdapter() {
        return AjaxAdapter
    }
    // websocket adapter
    static get WebSocketAdapter() {
        return WebSocketAdapter
    }
    // history module
    static get History() {
        return History
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
    // factory_dom element node
    static factory_dom(dom_string) {
        return Utility.factory_dom(dom_string)
    }
    // from JSON String convert to Object
    static json_decode(json_string) {
        try {
            return JSON.parse(json_string)
        } catch (e) {
            throw e;
        }
    }
    // from Object convert to JSON String
    static json_encode(object) {
        try {
            return JSON.stringify(object)
        } catch (e) {
            throw e
        }
    }
}

// export to global
window.$ = $
