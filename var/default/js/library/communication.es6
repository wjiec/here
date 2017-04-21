// import urlparse module
import { urlparse, urlunparse } from './urlparse.es6'
// import utils
import { Utility } from './utils.es6'

// NotImplemented Exception
class NotImplemented extends Error {
    constructor(message, eid) {
        super(message, eid)
    }
}

// Adapter Interface
class AdapterInterface {
    constructor(host = null, port = null) {
        this._host = host === null ? location.host : host
        this._port = port === null ? location.port : port
    }

    static is_available() {
        throw new NotImplemented('Derived class not implemented')
    }
}

// Ajax Adapter
class AjaxAdapter extends AdapterInterface {
    constructor(host = null, port = null) {
        super(host, port)
    }

    open(method, url, params = null, data = null, header = null) {
        return new Promise((resolve, reject) => {
            if (typeof(method) === 'string') {
                method = method.toUpperCase()
                if (this.http_methods.indexOf(method) === -1) {
                    reject(new Error(`the method '${method}' is not defined`))
                }
            } else {
                reject(new Error(`the method '${method}' is not string`))
            }

            if (typeof(url) !== 'string') {
                reject(new Error(`the url '${url}' is not string`))
            }

            // create XMLHttpRequest instance
            if (window.XMLHttpRequest === undefined) {
                reject(new Error('your browser is too old. please using Google Chrome or Firefox.'))
            }

            try {
                let _xhr = new XMLHttpRequest()

                if (header && typeof header === 'object') {
                    for (let key in header) {
                        _xhr.setRequestHeader(key, header[key])
                    }
                }

                if (data && typeof data === 'object') {
                    _xhr.setData(data)
                }

                if (params && typeof params === 'object') {
                    if (url.indexOf('?') === -1) {
                        url += '?'
                    }

                    for (let key in params) {
                        url += `${key}=${params[key]}&`
                    }
                    url = url.substr(0, url.length - 1)
                }

                _xhr.open(method, url)
                _xhr.onreadystatechange = this._state_change_handler(resolve, reject, _xhr)

                _xhr.send(null);
            } catch (e) {
                reject(new Error(e));
            }
        })
    }

    _state_change_handler(resolve, reject, xhr) {
        return (event) => {
            let response = { status: false }
            if (xhr.readyState === 4) {
                response.status = xhr.status
                if (xhr.status === 200) {
                    response.text = xhr.response
                    resolve(response)
                } else {
                    response.text = `HTTP ${xhr.status}}`
                    reject(response)
                }
            }
        }
    }

    get http_methods() {
        return [ 'GET', 'POST', 'PUT', 'DELETE', 'UPDATE' ]
    }

    static is_available() {
        return true
    }
}

// WebSocket Adapter
class WebSocketAdapter extends AdapterInterface {
    constructor(url = null, port = null, wss_server = false, timeout = 180) {
        super(url, port)

        this._is_wss_server = wss_server
        this._timeout = timeout

        if (port === 80) {
            this._url = `ws://${this._host}`
        } else if (port === 443) {
            this._url = `wss://${this._host}`
        } else {
            this._url = (wss_server === true ? 'wss://' : 'ws://') + this._host + (this._port === null ? '' : (':' + this._port))
        }

        this._timer_obj = null
        this._connection = null
        this._is_connected = false
        this._handlers = {
            connect: null, message: null,
            close: null, error: null
        }
        this._message_buffer = Array()
    }

    send_message(message) {
        if (Utility.is_plain_object(message)) {
            message = Utility.json_to_string(message)
        }

        if (!Utility.is_string(message)) {
            throw Error(`message except object or string, got ${typeof message}`)
        }

        this._create_connection()
        this._empty_message_buffer(message)
    }

    _create_connection() {
        if (this._connection === null || this._is_connected == null) {
            this._connection = new WebSocket(this._url)

            this._connection.addEventListener('open', this._on_connect_repeater.bind(this))
            this._connection.addEventListener('message', this._on_message_repeater.bind(this))
            this._connection.addEventListener('close', this._on_close_repeater.bind(this))
            this._connection.addEventListener('error', this._on_error_repeater.bind(this))
        }

        if (this._timer_obj !== null) {
            clearTimeout(this._timer_obj)
        }
        if (this._timeout > 0) {
            this._timer_obj = setTimeout(() => {
                this._connection.close()
                this._connection = null
                this._is_connected = false
            }, this._timeout * 1000)
        }
    }

    _empty_message_buffer(new_message) {
        if (Utility.is_string(new_message)) {
            this._message_buffer.push(new_message)
        }
        if (this._connection.readyState === WebSocket.OPEN) {
            while (this._message_buffer.length) {
                this._connection.send(this._message_buffer.shift())
            }
        }
    }

    _on_connect_repeater(event) {
        this._is_connected = true
        if (this._handlers.connect !== null) {
            this._handlers.connect(event)
        }
        this._empty_message_buffer(null)
    }

    _on_message_repeater(event) {
        if (this._handlers.message !== null) {
            this._handlers.message(event)
        }
    }

    _on_close_repeater(event) {
        this._connection = null
        this._is_connected = false
        if (this._handlers.close !== null) {
            this._handlers.close(event)
        }
    }

    _on_error_repeater(event) {
        this._connection = null
        this._is_connected = false
        if (this._handlers.error !== null) {
            this._handlers.error(event)
        }
    }

    set on_connect(callback) {
        if (typeof callback !== 'function') {
            throw new Error('connect callback is not callable object')
        }
        this._handlers.connect = callback
    }

    set on_message(callback) {
        if (typeof callback !== 'function') {
            throw new Error('message callback is not callable object')
        }
        this._handlers.message = callback
        if (this._connection !== null) {
            this._connection.addEventListener('message', this._handlers.message)
        }
    }

    set on_close(callback) {
        if (typeof callback !== 'function') {
            throw new Error('close callback is not callable object')
        }
        this._handlers.close = callback
        if (this._connection !== null) {
            this._connection.addEventListener('close', this._handlers.close)
        }
    }

    set on_error(callback) {
        if (typeof callback !== 'function') {
            throw new Error('error callback is not callable object')
        }
        this._handlers.error = callback
    }

    static is_available(cookie_name = 'wsp') {
        let websocket_port = Utility.get_cookie(cookie_name)
        if (websocket_port === null) {
            return false
        } else if (Utility.to_int(websocket_port) === null) {
            return false
        }
        return true
    }
}

// export adapter
export {AjaxAdapter, WebSocketAdapter}
