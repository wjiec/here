// import communication module
import {AjaxAdapter, WebSocketAdapter} from './communication.es6'

// History Node Class
class HisyoryNode {
    constructor(url, contents, extra_data = null, local_storage = false) {
        this._url = url
        this._contents = contents
        this._extra_data = extra_data
        this._local_storage = local_storage
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
}


// History Class
class History {
    static forward_ajax(method, url, callback, params = null, data = null, header = null, host = null, port = null) {
        let adapter = new AjaxAdapter(host, port)

        adapter.open(method, url, params, data, header).then(callback, callback)
    }

    static forward_websocket() {

    }

    static backward(callback, index = -1) {

    }

    static clear_all() {

    }

    static clear_after() {

    }
}


export {History}
