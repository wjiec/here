/* Base Module */

class $ {
    constructor(selector) {
        if (selector === docuemnt) {
            this._selector = selector
        }

        if (typeof selector === 'string') {
            this._selector = docuemnt.queryAllSelector(selector)
        }
    }

    static ready(methods, ...) {
        
    }
};