import {AjaxAdapter, WebSocketAdapter} from './history/communication.es6';
import {History} from './history/history.es6';
import {Utility} from './utils/utils.es6';
import {EventBus} from './event/event_bus.es6';
import {FormValidator} from './validator/form_validator.es6';

// `Here` Version
const HERE_VERSION = '0.1.0';

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
        } else if (Utility.is_dom_object(selector)) {
            this._selector = [selector];
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
                if (!this._selector[0].getAttribute(key)) {
                    return this._selector[0][key];
                }
                return this._selector[0].getAttribute(key);
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
    // foreach all element
    foreach(callback) {
        if (!Utility.is_function(callback)) {
            throw new Error('foreach callback is not function');
        }
        // foreach
        if (this._selector !== document) {
            this._selector.forEach((el, index) => {
                callback(new $(el), index);
            });
        }
    }
    // getting/setting value
    value(val = null) {
        if (this._selector.length !== 0) {
            if (val === null) {
                return this._selector[0].value;
            } else {
                this._selector[0].value = val;
            }
        }
    }
    // element count
    get length() {
        return this._selector.length;
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

// export Class to window
window.$ = $;

// create instance method
window.$$ = function(selector) {
    return new $(selector);
};

// ["\n %c %c %c Pixi.js " + i.VERSION + " - ✰ " + e + " ✰  %c  %c  http://www.pixijs.com/  %c %c ♥%c♥%c♥ \n\n", "background: #ff66a5; padding:5px 0;", "background: #ff66a5; padding:5px 0;", "color: #ff66a5; background: #030307; padding:5px 0;", "background: #ff66a5; padding:5px 0;", "background: #ffc3dc; padding:5px 0;", "background: #ff66a5; padding:5px 0;", "color: #ff2424; background: #fff; padding:5px 0;", "color: #ff2424; background: #fff; padding:5px 0;", "color: #ff2424; background: #fff; padding:5px 0;"];
const _console_common_style = `line-height: 2.333; color: #fff; padding: 5px 0;`;
// display Here Information in Chrome Console
console.log(`%c %c %c %c Here Blogger ➼ ${HERE_VERSION} %c %c %c %c https://github.com/JShadowMan/here.git %c %c %c %c %c☀%c☀%c☀`,
    // Package Name [Start]
    `${_console_common_style};background: #096;`,
    `${_console_common_style};background: #099;`,
    `${_console_common_style};background: #09c;`,
    // // Package Name [Text]
    `${_console_common_style};background: #369;`,
    // Package Name [End], Repo Address [Start]
    `${_console_common_style};background: #09c;`,
    `${_console_common_style};background: #099;`,
    `${_console_common_style};background: #096;`,
    // Repo Address [Text]
    `${_console_common_style};background: #369;`,
    // Repo Address [End], Three-Sun [Start]
    `${_console_common_style};background: #096;`,
    `${_console_common_style};background: #099;`,
    `${_console_common_style};background: #09c;`,
    // blank text
    `${_console_common_style};background: #fff;`,
    // Three-Sun 0
    `${_console_common_style};color: #f06;`,
    // Three-Sun 1
    `${_console_common_style};color: #f03;`,
    // Three-Sun 2
    `${_console_common_style};color: #f00;`,
);