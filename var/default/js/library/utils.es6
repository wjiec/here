/* Utility Module */

// static class
class Utility {
    static get_cookie(cookie_name) {
        let cookies = document.cookie

        let start_index = cookies.indexOf(cookie_name)
        // cookies non-exists
        if (start_index === -1) {
            return false
        }
        start_index += cookie_name.length + 1

        let end_index = cookies.indexOf(';', start_index)
        // in last item
        if (end_index === -1) {
            end_index = cookies.length
        }
        return cookies.substring(start_index, end_index)
    }

    static to_int(value) {
        let num = parseInt(value)

        return isNaN(num) ? null : num;
    }

    static is_plain_object(object) {
        if (!object || toString(object) !== '[object Object]') {
            return false
        }

        let proto = Object.getPrototypeOf(object)
        if (!proto) {
            return true
        }

        let c_tor = {}.hasOwnProperty.call(proto, 'constructor') && proto.constructor

        return typeof c_tor === 'function' && {}.hasOwnProperty.toString.call(c_tor) === {}.hasOwnProperty.toString.call(object)
    }

    static json_to_string(object) {
        try {
            return JSON.stringify(object)
        } catch (e) {
            return null
        }
    }

    static is_string(object) {
        return typeof object === 'string'
    }
}

// export Utility class
export { Utility }