// import communication module
import {AjaxAdapter, WebSocketAdapter} from './communication.es6'
import {urlparse} from './urlparse.es6'
import {Utility} from './utils.es6'

// History Node Class
class HistoryNode {
    constructor(url, contents, adapter, selector, extra_data = null) {
        this._url = url
        this._guid = Utility.generate_guid()
        this._adapter = adapter
        this._contents = contents
        this._selector = selector
        this._extra_data = extra_data
    }

    cache_node() {
        if (window.localStorage === undefined) {
            throw new Error(`localStorage does't supported`)
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

    toString() {
        return Utility.json_to_string(this.toObject())
    }

    toObject() {
        return {
            url: this._url,
            contents: this._contents,
            adapter: this._adapter.toString(),
            selector: this._selector,
            extra_data: Utility.json_to_string(this._extra_data),
            local_storage: this._local_storage,
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
    static init_history() {
        if (window.history.pushState === undefined || window.onpopstate === undefined) {
            throw new Error(`Your browser does't support HTML5 history API`)
        }

        window.onpopstate = History.on_pop_state
    }
    // pop state handler
    static on_pop_state(event) {
        let state = event.state
        console.log(state)
        let selector = state.selector
        let container = document.querySelector(selector)
        if (container === null) {
            throw new Error(`selector('${selector}') not found in document`)
        }
        // from sessionStorage fetch data
        History.replace_contents(container, state.contents, selector)
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
            if (!Utility.is_string(replace_selector)) {
                throw Error(`replace selector except str, got ${typeof replace_selector}`)
            }
            let selector = document.querySelector(replace_selector)
            if (selector === null) {
                throw Error(`replace select '${replace_selector}' not found`)
            }

            let old_url = [location.pathname, location.search, location.hash].join('')
            let old_contents = selector.innerHTML
            let history_node = new HistoryNode(old_url, old_contents, AjaxAdapter, replace_selector, {}, true)
            history_node.cache_node()
            window.history.pushState(history_node.toObject(), 'Test', url)

            this.replace_contents(selector, response.text, replace_selector)
        }, (response) => {
            console.log(response)
            // display error information
        })
    }
    // forward by WebSocket
    static forward_websocket(url, port = null, is_secure = false, timeout = 180) {
        if (History._websocket_adapter === null) {
            History._websocket_adapter = new WebSocketAdapter(url, port, is_secure, timeout)
        }
    }
    // backward
    static backward(callback, index = -1) {

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

// initializing History env
History.init_history()
// export History methods
export {History}
