/**
 * form validator module
 *
 * @package Here
 * @author ShadowMan
 */
import {Utility} from '../utils/utils.es6'

class FormValidator {
    /**
     * @param HTMLElement input
     * @param Object rules
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

        this._parse_input_pre();
        this._parse_rules_pre();
    }

    _parse_input_pre() {
        // check tag name
        if (this._input.tagName !== 'input') {
            throw Error('input parameter is not input element')
        }

        this._input_name = this._input.name
        this._input_value = this._input.value
    }

    _parse_rules_pre() {
        this._flag_empty = this._from_rules_get('empty');
        this._flag_min_length = this._from_rules_get('min_length', this._from_rules_get('length'));
        this._flag_max_length = this._from_rules_get('max_length');
        this._flag_regex = this._from_rules_get('regex')
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

    }

    static get common_regex_library() {
        return {
            'email': /^[\w!$_~-]+(?:\.[\w!$_~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?$/,
            'phone': /^1[34578]\d{9}$/
        }
    }
}

export {FormValidator};