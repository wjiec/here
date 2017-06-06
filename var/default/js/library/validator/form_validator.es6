/**
 * form validator module
 *
 * @package Here
 * @author ShadowMan
 */
import {Utility} from '../utils/utils.es6'

class FormValidator {
    /**
     * @param input HTMLElement
     * @param rules Object
     */
    constructor(input, rules) {
        if (!Utility.is_dom_object(input)) {
            throw Error('input is not HTMLElement Object');
        }
        this._input = input;

        if (!Utility.is_plain_object(rules)) {
            throw Error('rule except Object type');
        }
        this._rules = rules;
        // check pre parse
        this._parse_input_pre();
        this._parse_rules_pre();
        try {
            // start check
            this._check();
            // setting status and message
            this._status = true;
            // message
            this._message = null;
        } catch (except) {
            // error status
            this._status = false;
            // message is Exception message
            this._message = except.message;
        }

    }

    /**
     * check result handler
     *
     * @param callback
     */
    then(callback) {
        if (!Utility.is_function(callback)) {
            throw Error('callback except callable object');
        }
        callback(new $(this._input), this._status, this._message);
    }

    _parse_input_pre() {
        // check tag name
        if (this._input.tagName.toLowerCase() !== 'input') {
            throw Error('input parameter is not input element')
        }
        this._input_name = this._input.name;
        this._input_value = this._input.value.trim()
    }

    _parse_rules_pre() {
        this._flag_empty = this._from_rules_get('empty', null);
        this._flag_min_length = this._from_rules_get('min_length', this._from_rules_get('length'));
        this._flag_max_length = this._from_rules_get('max_length');
        this._flag_regex = this._from_rules_get('regex')
    }

    _check() {
        // check value is empty
        if (this._flag_empty !== false) {
            if (this._input_value.length === 0) {
                throw Error('FormValidator:Error:value is empty');
            }
        }
        // check value length
        if (this._flag_min_length || this._flag_max_length) {
            // check min length
            if (this._flag_min_length) {
                if (this._input_value.length < this._flag_min_length) {
                    throw Error('FormValidator:Error:value too short');
                }
            }
            // check max_length is correct
            if (this._flag_max_length && this._flag_max_length <= this._flag_min_length) {
                throw Error('FormValidator:Error:max_length invalid');
            }
            // check max length
            if (this._flag_max_length) {
                if (this._input_value.length > this._flag_max_length) {
                    throw Error('FormValidator:Error:value too long');
                }
            }
        }
        // regex
        if (this._flag_regex) {
            if (typeof this._flag_regex === 'object' && ('test' in this._flag_regex)) {
                if (this._flag_regex.test(this._input_value) !== true) {
                    throw Error('FormValidator:Error:regex validate error');
                }
            } else if (Utility.is_string(this._flag_regex)) {
                let pattern = FormValidator.common_regex(this._flag_regex);
                if (pattern === null) {
                    throw Error('FormValidator:Error:pattern non exists');
                } else {
                    if (pattern.test(this._input_value) !== true) {
                        throw Error('FormValidator:Error:regex validate error');
                    }
                }
            }
        }
    }

    _from_rules_get(key, default_value = false) {
        if (key in this._rules) {
            return this._rules[key];
        }
        return default_value;
    }

    get name() {
        return this._input_name;
    }

    get value() {
        return this._input_value;
    }

    static common_regex(key) {
        if (key in FormValidator.common_regex_library) {
            return FormValidator.common_regex_library[key];
        }
        return null;
    }

    static get common_regex_library() {
        return {
            'email': /^[\w!$_~-]+(?:\.[\w!$_~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?$/,
            'phone': /^1[34578]\d{9}$/
        }
    }
}

export {FormValidator};