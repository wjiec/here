//
// This file is part of here
//

export default class Selector {
  constructor(selector, target = document) {
    this.fn = {};
    if (typeof selector === 'string') {
      this.el = target.querySelectorAll(selector);
    } else if (typeof selector === 'object') {
      this.el = [selector];
    }
  }

  get elem() {
    if (this.el.length) {
      return this.el[0];
    }
    return null;
  }

  each(cb) {
    this.el.forEach((el) => {
      cb(new Selector(el));
    })
  }

  query(selector) {
    return new Selector(selector, this.elem);
  }

  bind(name, fn) {
    this.fn[name] = fn;
    this.elem.addEventListener(name, fn);
  }

  unbind(name) {
    if (this.fn[name]) {
      this.elem.removeEventListener(name, this.fn[name]);
      delete this.fn[name];
    }
  }
}
