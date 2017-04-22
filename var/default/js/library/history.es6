// import communication module
import {AjaxAdapter, WebSocketAdapter} from './communication.es6'
import {Utility} from './utils.es6'


// History Node Class
class HistoryNode {
    constructor(url, contents, adapter, extra_data = null, local_storage = false) {
        this._url = url
        this._adapter = adapter
        this._contents = contents
        this._extra_data = extra_data
        this._local_storage = local_storage
    }

    save() {
        let item_key = [History.Static_Node_Index, this._url, (new Date()).getTime().toString()].join('_')
        console.log(item_key)
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

    get local_storage() {
        return this._local_storage
    }

    set local_storage(new_local_storage) {
        this._local_storage = new_local_storage
    }

    toString() {
        return Utility.json_to_string(this.toObject())
    }

    toObject() {
        return {
            url: this._url,
            contents: this._contents,
            extra_data: Utility.json_to_string(this._extra_data),
            local_storage: this._local_storage
        }
    }
}


// History Class
class History {
    static forward_ajax(method, url, replace_selector, params = null, data = null, header = null, host = null, port = null) {
        let adapter = new AjaxAdapter(host, port)

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
            let history_node = new HistoryNode(old_url, old_contents, AjaxAdapter, {}, true)
            history_node.save()
            window.history.pushState(history_node.toObject(), 'Test', url)

            let container = document.createElement('div')
            // is full-html document
            if (/<html/i.test(response.text)) {
                let body_text = response.text.match(/<body[^>]*>[\s\S]*<\/body>/i)[0]
                container.innerHTML = body_text

                let new_selector = container.querySelector(replace_selector)
                if (new_selector === null) {
                    throw new Error(`'${url}' is not contain ${replace_selector}`)
                }
                selector.parentNode.replaceChild(new_selector, selector)
            } else {
                container.innerHTML = response.text

                // It's just replace-selector child-nodes
                if (container.querySelector(replace_selector) === null) {
                    selector.innerHTML = container.innerHTML
                // It's container
                } else {
                    selector.parentNode.replaceChild(container.querySelector(replace_selector), selector)
                }
            }
        }, (response) => {
            // display error information
        })
    }

    static forward_websocket(url, port = null, is_secure = false, timeout = 180) {
        if (History._websocket_adapter === null) {
            History._websocket_adapter = new WebSocketAdapter(url, port, is_secure, timeout)
        }
    }

    static backward(callback, index = -1) {

    }

    static clear_all() {

    }

    static clear_after() {

    }

    static get_static_node_index() {
        if (!('local_storage_node_index' in localStorage)) {
            localStorage.setItem('local_storage_node_index', 0)
        }
        return Utility.to_int(localStorage.getItem('local_storage_node_index'))
    }
}
// History Static Member
History.Static_Node_Index = History.get_static_node_index()

export {History}
