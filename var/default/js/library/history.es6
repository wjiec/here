// import communication module
import {AjaxAdapter, WebSocketAdapter} from './communication.es6'
import {urlparse} from './urlparse.es6'
import {Utility} from './utils.es6'

// History Node Class
class HistoryNode {
    constructor(url, contents, adapter, selector, title, extra_data = null) {
        this._url = url
        this._title = title
        this._guid = Utility.generate_guid()
        this._adapter = adapter
        this._contents = contents
        this._selector = selector
        this._extra_data = extra_data
    }

    cache_node() {
        if (!window.localStorage || !window.sessionStorage) {
            throw new Error(`WebStorage does't supported`)
            return null
        }
        HistoryNode.trim_history_list(HistoryNode.max_local_storage_length)
        HistoryNode._storage_adapter.setItem(this._guid, this.toString())
        HistoryNode.history_list_append(this._guid)
    }

    get url() {
        return this._url
    }

    set url(new_url) {
        this._url = new_url
    }

    get contents() {
        return this._contents
    }

    set contents(new_contents) {
        this._contents = new_contents
    }

    get extra_data() {
        return this._extra_data
    }

    set extra_data(new_extra_data) {
        this._extra_data = new_extra_data
    }

    get selector() {
        return this._selector
    }

    set selector(new_selector) {
        this._selector = new_selector
    }

    get title() {
        return this._title
    }

    set title(new_title) {
        this._title = new_title
    }

    toString() {
        return Utility.json_to_string(this.toObject())
    }

    toObject() {
        return {
            url: this._url,
            contents: this._contents,
            adapter: this._adapter.toString(),
            selector: this._selector,
            title: this._title,
            extra_data: Utility.json_to_string(this._extra_data),
            local_storage_id: this._guid
        }
    }

    static get storage_adapter() {
        if (!HistoryNode._storage_adapter) {
            HistoryNode._storage_adapter = window.localStorage
        }
        return HistoryNode._storage_adapter
    }

    static set storage_adapter(adapter) {
        if (adapter === window.localStorage || adapter === window.sessionStorage) {
            HistoryNode._storage_adapter = adapter
        }
    }

    static get max_local_storage_length() {
        return 16;
    }

    static trim_history_list(new_length = 8) {
        let history_list = HistoryNode.local_history_list
        // trim extra history
        while (history_list.length > new_length) {
            let guid = history_list.shift()
            HistoryNode._storage_adapter.removeItem(guid)
        }
        HistoryNode.local_hisory_list = history_list
    }

    static get local_history_list() {
        let list = HistoryNode._storage_adapter.getItem('history_list')
        return Utility.string_to_json(list == null ? '[]' : list)
    }

    static set local_history_list(object) {
        HistoryNode._storage_adapter.setItem('history_list', Utility.json_to_string(object))
    }

    static history_list_append(guid) {
        let new_list = HistoryNode.local_hisory_list
        new_list.push(guid)
        HistoryNode.local_history_list = new_list
    }
}


// History Class
class History {
    // history api initializing
    static init_history(url = null, port = null, is_secure = false, timeout = 180) {
        // init websocket
        if (!History._websocket_adapter) {
            // self initializing
            History._websocket_adapter = new WebSocketAdapter(url, port, is_secure, timeout)

            if (window.history.pushState === undefined || window.onpopstate === undefined) {
                throw new Error(`Your browser does't support HTML5 history API`)
            }
            // bind popstate
            window.addEventListener('popstate', History.on_pop_state);
            // custom events
            History._custom_events = {
                'History:error': [],
                'History:success': []
            }
        } else if (url || port) {
            // user initializing
            History._websocket_adapter = new WebSocketAdapter(url, port, is_secure, timeout)
        }
    }
    // bind custom events
    static on(event_name, callback) {
        if (History._custom_events.hasOwnProperty(event_name)) {
            if (!Utility.is_function(callback)) {
                throw new Error(`event callback is not callable`)
            }
            History._custom_events[event_name].push(callback)
        } else {
            throw new Error('event name not found')
        }
    }
    // pop state handler
    static on_pop_state(event) {
        let state = event.state
        let selector = state.selector
        let container = document.querySelector(selector)
        if (container === null) {
            throw new Error(`selector('${selector}') not found in document`)
        }
        // from sessionStorage fetch data
        History.replace_contents(container, state.contents, selector)
        // set document title
        document.title = state.title
    }
    // forward by Ajax
    static forward_ajax(method, url, replace_selector, params = null, data = null, header = null, host = null, port = null) {
        let adapter = new AjaxAdapter(host, port)

        if (header === null) {
            header = {}
        }
        header['X-Forward-Position'] = urlparse(url).path
        header['X-Forward-Contents'] = replace_selector

        adapter.open(method, url, params, data, header).then((response) => {
            History.request_success(url, response, replace_selector)
        }, (response) => {
            console.log(response)
            let callbacks = History._custom_events['History:error']

            // dispatch error response
            for (let index = 0; index < callbacks.length; ++index) {
                callbacks[index](response)
            }
            // display error information
        })
    }
    // forward by WebSocket
    static forward_websocket(method, url, replace_selector, params = null, data = null, header = null, host = null, port = null) {
        if (header === null) {
            header = {}
        }
        header['X-Forward-Position'] = urlparse(url).path
        header['X-Forward-Contents'] = replace_selector

        let message = {
            method: method,
            url: url,
            selector: replace_selector,
            params: params,
            data: data,
            header: header
        }
        let string_message = Utility.json_to_string(message)
        History._websocket_adapter.one(string_message).then((response) => {
            let object_response = Utility.string_to_json(response)
            History.request_success(url, object_response, replace_selector)
        }, (event) => {
            // error occurs
            console.warn('WebSocketAdapter error occurs, instead of using AjaxAdapter')
            // using Ajax request
            History.forward_ajax(method, url, replace_selector, params, data, header, host, port)
        })
    }
    // request success
    static request_success(url, response, replace_selector) {
        if (!Utility.is_string(replace_selector)) {
            throw Error(`replace selector except str, got ${typeof replace_selector}`)
        }
        let selector = document.querySelector(replace_selector)
        if (selector === null) {
            throw Error(`replace select '${replace_selector}' not found`)
        }

        let new_contents = History.find_new_contents(response.text, replace_selector)
        let new_title = History.find_title(response)
        let history_node = new HistoryNode(url, new_contents, AjaxAdapter, replace_selector, new_title, {})
        history_node.cache_node()

        History.push_state(history_node.toObject(), new_title, url)
        this.replace_contents(selector, response.text, replace_selector)
    }
    // find new contents
    static find_new_contents(response, selector) {
        let container = document.createElement('div')

        if (/<html/i.test(response)) {
            let body_text = new_contents.match(/<body[^>]*>[\s\S]*<\/body>/i)[0]
            container.innerHTML = body_text

            let element = container.querySelector(selector)
            if (element === null) {
                throw new Error(`'${url}' is not contain ${selector}`)
            }
            return element.innerHTML
        } else {
            container.innerHTML = response
            // It's just replace-selector child-nodes
            if (container.querySelector(selector) === null) {
                return container.innerHTML
                // It's container
            } else {
                return response
            }
        }
    }
    // push state
    static push_state(state, title, url) {
        if (history.state === null) {
            let old_url = Utility.get_current_url()
            let element = document.querySelector(state.selector)
            if (element === null) {
                throw new Error(`selector( ${state.selector} ) is non exists`)
            }
            let old_contents = element.innerHTML
            let current_state = new HistoryNode(old_url, old_contents, AjaxAdapter, state.selector, document.title, {})
            // replace null state
            window.history.replaceState(current_state.toObject(), document.title, old_url)
        }
        window.history.pushState(state, title, url)

        if (Utility.is_string(title)) {
            document.title = title
        }
    }
    // find title from response
    static find_title(response) {
        // from response getting title
        for (let key in response.headers) {
            let lower_key = key.toLowerCase()

            if (lower_key.indexOf('title') !== -1) {
                return response.headers[key]
            }
        }

        // is full-html document
        if (/<html/i.test(response.text)) {
            let title = response.text.match(/<title\s*[^>]*>(.*)<\/title>/)

            if (title.length) {
                return title[1]
            }
        }

        let container = document.createElement('div')
        container.innerHTML = response.text
        let id_title = container.querySelector('#title')
        let class_title = container.querySelector('.title')

        if (id_title !== null) {
            return id_title.innerText
        }
        if (class_title !== null) {
            return class_title.innerText
        }
        return null
    }
    // replace contents
    static replace_contents(old_container, new_contents, replace_selector) {
        let container = document.createElement('div')
        // is full-html document
        if (/<html/i.test(new_contents)) {
            let body_text = new_contents.match(/<body[^>]*>[\s\S]*<\/body>/i)[0]
            container.innerHTML = body_text

            let new_selector = container.querySelector(replace_selector)
            if (new_selector === null) {
                throw new Error(`'${url}' is not contain ${replace_selector}`)
            }
            /**
             * @TODO easing animation
             */
            old_container.parentNode.replaceChild(new_selector, old_container)
        } else {
            container.innerHTML = new_contents
            // It's just replace-selector child-nodes
            if (container.querySelector(replace_selector) === null) {
                /**
                 * @TODO easing animation
                 */
                old_container.innerHTML = container.innerHTML
            // It's container
            } else {
                /**
                 * @TODO easing animation
                 */
                old_container.parentNode.replaceChild(container.querySelector(replace_selector), old_container)
            }
        }
    }
}
// default Storage adapter
if (window.sessionStorage && window.localStorage) {
    HistoryNode._storage_adapter = window.sessionStorage
} else {
    class NonSupportStorage {
        setItem() {}
        getItem() {}
        removeItem() {}
        get length() {return 0}
    }
    HistoryNode._storage_adapter = new NonSupportStorage()
}

// self initializing History env
History.init_history()
// export History methods
export {History}
