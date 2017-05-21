// urlparse module
const scheme_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+-.';
const uses_params = ['ftp', 'hdl', 'prospero', 'http', 'imap', 'https', 'shttp', 'rtsp', 'rtspu', 'sip', 'sips', 'mms', '', 'sftp', 'tel'];
const uses_netloc = ['ftp', 'http', 'gopher', 'nntp', 'telnet', 'imap', 'wais', 'file', 'mms', 'https', 'shttp', 'snews', 'prospero', 'rtsp', 'rtspu', 'rsync', '', 'svn', 'svn+ssh', 'sftp','nfs','git', 'git+ssh'];

/**
 * Result Classes
 *
 */
class SplitResult {
    /**
     * constructor
     */
    constructor(scheme, netloc, path, query, fragment) {
        this._fragment = fragment;
        this._scheme = scheme;
        this._netloc = netloc;
        this._query = query;
        this._path = path;
    }

    get username() {
        let netloc = this._netloc;

        if (netloc.includes('@')) {
            let user_info = netloc.split('@', 2)[0];

            if (user_info.includes(':')) {
                user_info = user_info.split(':', 2)[0];
            }

            return user_info;
        } else {
            return null;
        }
    }

    get password() {
        let netloc = this._netloc;

        if (netloc.includes('@')) {
            let user_info = netloc.split('@', 2)[0];

            if (user_info.includes(':')) {
                user_info = user_info.split(':', 2)[1];
            }

            return user_info;
        } else {
            return null;
        }
    }

    get hostname() {
        let netloc = this._netloc;

        if (netloc.includes('[') && netloc.includes(']')) {
            return netloc.split(']')[0].substr(1).toLowerCase();
        } else if (netloc.includes(':')) {
            return netloc.split(':')[0].toLowerCase();
        } else if (netloc === '') {
            return null;
        } else {
            return netloc.toLowerCase();
        }
    }

    get port() {
        let netloc = this._netloc.split('@');
        netloc = netloc[netloc.length - 1].split(']');
        netloc = netloc[netloc.length - 1];

        if (netloc.includes(':')) {
            let port = netloc.split(':')[1];

            if (port) {
                port = parseInt(port);
                if (0 <= port && port <= 65535) {
                    return port;
                }
            }
        }

        return null;
    }

    get scheme() {
        return this._scheme;
    }

    get netloc() {
        return this._netloc;
    }

    get path() {
        return this._path;
    }

    get query() {
        return this._query;
    }

    get fragment() {
        return this._fragment;
    }
}

class ParseResult extends SplitResult {
    /**
     * constructor
     */
    constructor(scheme, netloc, path, params, query, fragment) {
        super(scheme, netloc, path, query, fragment);

        this._params = params;
    }

    get params() {
        return this._params;
    }

    get_url() {
        return urlunparse(this._scheme, this._netloc, this._path, this._params, this._query, this._fragment);
    }
}

function _split_netloc(url, start = 0) {
    let delim = url.length;

    for (let char_index in [ '/', '?', '#' ]) {
        let char = [ '/', '?', '#' ][char_index];
        let wdelim = url.indexOf(char, start);

        if (wdelim >= 0) {
            delim = Math.min(delim, wdelim);
        }
    }
    return { 'domain': url.substr(start, delim - start), 'rest': url.substr(delim) };
}

/**
 * Parse a URL into 5 components:
 * <scheme>://<netloc>/<path>?<query>#<fragment>
 * Return an object.
 * {
 *     scheme: '',
 *     netloc: '',
 *     path: '',
 *     query: '',
 *     fragment: ''
 * }
 *
 * @return object
 * @params url String
 */
function _url_split(url, scheme = '', allow_fragments = true) {
    let fragment = '';
    let netloc = '';
    let query = '';

    // find :
    let index = url.indexOf(':');
    if (index > 0) {
        scheme = url.substr(0, index);
        scheme = scheme.toLowerCase();

        // optimize the common case
        if (scheme === 'http') {
            url = url.substr(index + 1);

            if (url.substr(0, 2) === '//') {
                let split_netloc = _split_netloc(url, 2);

                netloc = split_netloc.domain;
                url = split_netloc.rest;

                if ((netloc.includes('[') && !netloc.includes(']'))
                    || (netloc.includes(']') && !netloc.includes('['))) {
                    throw 'Invalid IPv6 URL';
                }
            }

            if (allow_fragments && url.includes('#')) {
                let split_fragment = url.split('#', 2);

                url = split_fragment[0];
                fragment = split_fragment[1];
            }

            if (url.includes('?')) {
                let split_query = url.split('?', 2);

                url = split_query[0];
                query = split_query[1];
            }

            return new SplitResult(scheme, netloc, url, query, fragment);
        }

        let includes_flag = true;
        for (let char_index = 0; char_index < scheme.length; ++char_index) {
            if (!scheme_chars.includes(scheme[char_index])) {
                includes_flag = false;
                break;
            }
        }
        if (includes_flag === true) {
            let rest = url.substr(index + 1);

            let is_port_flag = true;
            for (let index = 0; index < rest.length; ++index) {
                if (!('0123456789'.includes(rest[index]))) {
                    is_port_flag = false;
                    break;
                }
            }

            // make sure "url" is not actually a port number
            if (!rest || !is_port_flag) {
                url = rest;
            }
        }
    }

    if (url.substr(0, 2) === '//') {
        let split_netloc = _split_netloc(url, 2);

        netloc = split_netloc.domain;
        url = split_netloc.rest;

        if ((netloc.includes('[') && !netloc.includes(']'))
            || (netloc.includes(']') && !netloc.includes('['))) {
            throw 'Invalid IPv6 URL';
        }
    }

    if (allow_fragments && url.includes('#')) {
        let split_fragment = url.split('#', 2);

        url = split_fragment[0];
        fragment = split_fragment[1];
    }

    if (url.includes('?')) {
        let split_query = url.split('?', 2);

        url = split_query[0];
        query = split_query[1];
    }

    return new SplitResult(scheme, netloc, url, query, fragment);
}

function _split_params(url) {
    let index = -1;
    if (url.includes('/')) {
        index = url.indexOf(';', url.lastIndexOf('/'));

        if (index < 0) {
            return [ url, '' ];
        }
    } else {
        index = url.indexOf(';');
    }

    return [ url.substr(0, index), url.substr(index + 1) ];
}

function urlparse(url, scheme = '', allow_fragments = true) {
    let split_result = _url_split(url, scheme, allow_fragments);
    let params_split_result = '';

    if (uses_params.includes(split_result.scheme) && url.includes(';')) {
        params_split_result = _split_params(url);
    } else {
        params_split_result = [ split_result.path, '' ];
    }

    return new ParseResult(split_result.scheme, split_result.netloc, params_split_result[0], params_split_result[1], split_result.query, split_result.fragment);
}

function _url_unsplit(scheme, netloc, url, query, fragment) {
    if (netloc || (scheme && uses_netloc.includes(netloc) && url.substr(0, 2) !== '//')) {
        if (url && url.substr(0, 1) !== '/') {
            url = '/' + url;
        }

        url = '//' + (netloc || '') + url;
    }
    if (scheme) {
        url = scheme + ':' + url;
    }
    if (query) {
        url = url + '?' + query;
    }
    if (fragment) {
        url = url + '#' + fragment;
    }

    return url;
}

function urlunparse(scheme, netloc, url, params, query, fragment) {
    if (params.length) {
        url = url + ';' + params;
    }

    return _url_unsplit(scheme, netloc, url, query, fragment);
}

export { urlparse, urlunparse }
