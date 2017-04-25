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
        console.log(toString(object))
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

    static string_to_json(string) {
        try {
            return JSON.parse(string)
        } catch (e) {
            return Object()
        }
    }

    static is_string(object) {
        return typeof object === 'string'
    }

    static is_function(object) {
        return typeof object === 'function'
    }

    static generate_guid() {
        function __rstr() {
            return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1)
        }
        return (__rstr() + __rstr() + "-" + __rstr() + "-" + __rstr() + "-" + __rstr() + "-" + __rstr() + __rstr() + __rstr())
    }

    static factory_dom(dom_string) {
        if (!Utility.is_string(dom_string)) {
            throw new Error(`HTML string except string, got ${typeof dom_string}`)
        }

        if (!/<([\w]+)\s+[^>]*>.*<\/\1>/.test(dom_string)) {
            throw new Error('HTML string invalid')
        }

        let tag_name = dom_string.match(/<([\w]+)/)[1]
        let dom_contents = dom_string.match(/<([\w]+)\s+[^>]*>(.*)<\/\1>/)[2]
        let container = document.createElement(tag_name)
        container.innerHTML = dom_contents

        return container
    }

    static trim(string) {
        return string.replace(/(^\s*)|(\s*$)/g, "");
    }

    static get_current_url() {
        return [location.pathname, location.search, location.hash].join('')
    }
}

// export Utility class
export { Utility }
