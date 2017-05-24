import {AjaxAdapter, WebSocketAdapter} from './history/communication.es6';
import {History} from './history/history.es6';
import {Utility} from './utils/utils.es6';
import {EventBus} from './event/event_bus.es6';
import {FormValidator} from './validator/form_validator.es6';

/* Base Module */
export default class $ {
    // HereJavascriptFramework Constructor
    constructor(selector) {
        // initializing selector
        if (selector === document) {
            this._selector = selector;
        } else if (Utility.is_string(selector)) {
            this._selector = document.querySelectorAll(selector);

            if (this._selector === null) {
                throw new Error(`selector ('${selector}') not found`);
            }
        } else {
            throw Error('Selector invalid');
        }
    }
    // event bind method
    on(event_name, event_callback, use_capture = false) {
        // check event name and callback is correct
        if (!Utility.is_string(event_name) || !Utility.is_function(event_callback)) {
            throw Error('event name or callback invalid');
        }
        // trim 'on'
        if (event_name.indexOf('on') === 0) {
            event_name = event_name.substr(2);
        }
        // foreach all node
        if (this._selector === document) {
            // only this way? addEventListener is invalid
            document[`on${event_name}`] = event_callback;
        } else {
            // add event listener
            [].forEach.call(this._selector, (selector) => {
                selector.addEventListener(event_name, event_callback, use_capture);
            });
        }
        // chaining-call
        return this;
    }
    // unbind event
    unbind(event_name, event_callback) {
        // check event name and callback is correct
        if (!Utility.is_string(event_name) || !Utility.is_function(event_callback)) {
            throw Error('event name or callback invalid');
        }
        // trim 'on'
        if (event_name.indexOf('on') === 0) {
            event_name = event_name.substr(2);
        }
        // foreach all node
        [].forEach.call(this._selector, (selector) => {
            selector.removeEventListener(event_name, event_callback);
        });
    }
    // getting/setting innerHTML
    text(new_content = null) {
        // getting
        if (new_content === null) {
            return (this._selector.length === 0) ? null : this._selector[0].innerHTML;
        } else {
            // setting
            if (this._selector.length !== 0) {
                this._selector[0].innerHTML = new_content;
            }
        }
    }
    // concat new content
    inner_concat(content) {
        if (this._selector.length !== 0) {
            this._selector[0].innerHTML += content;
        }
    }
    // add style class
    add_class(class_name) {
        if (this._selector.length !== 0) {
            this._selector[0].classList.add(class_name);
        }
    }
    // remove style class
    remove_class(class_name) {
        if (this._selector.length !== 0) {
            let class_list = this._selector[0].classList;
            let select_index = class_list.indexOf(class_name);
            // class not found
            if (select_index !== -1) {
                this._selector[0].classList.splice(select_index, 1);
            }
        }
    }
    // set attribute
    attribute(key, value = null, use_real = false) {
        // getting attribute
        if (value === null) {
            if (this._selector.length !== 0) {
                this._selector[0].getAttribute(key);
            }
        } else {
            // setting attribute
            if (use_real === true) {
                this._selector[0][key] = value;
            } else {
                this._selector[0].setAttribute(key, value);
            }
        }
    }
    // getting dom object @TODO deserted
    get element() {
        if (this._selector.length === 1) {
            return this._selector[0];
        }
        return this._selector;
    }
    // utility method
    static ready(ready_callback) {
        if (Utility.is_function(ready_callback)) {
            document.addEventListener('DOMContentLoaded', ready_callback, true);
        } else {
            throw Error('ready_callback is not function');
        }
    }
    // factory_dom element node
    static factory_dom(dom_string) {
        return Utility.factory_dom(dom_string);
    }
    // ajax adapter
    static get AjaxAdapter() {
        return AjaxAdapter;
    }
    // websocket adapter
    static get WebSocketAdapter() {
        return WebSocketAdapter;
    }
    // history module
    static get History() {
        return History;
    }
    // event bus module
    static get EventBus() {
        return EventBus;
    }
    // form validator module
    static get FormValidator() {
        return FormValidator;
    }
    // Utility Module
    static get Utility() {
        return Utility;
    }
}

// export to global
window.$ = $;
