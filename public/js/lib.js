window._$ = (target, selector) => {
  if (!selector) {
    [selector, target] = [target, document];
  }
  return target.querySelector(selector)
};
window._$$ = (target, selector) => {
  if (!selector) {
    [selector, target] = [target, document];
  }
  return target.querySelectorAll(selector)
};
window._$on = (target, e, callback) => {
  if (typeof target === 'string') {
    target = _$(target)
  }
  return target.addEventListener(e, callback, true)
};

class Validator {
  constructor(form) {
    this.form = form;
    _$on(this.form, 'input', () => this.validate());
  }

  validate() {
    let validate = true;
    _$$(this.form, '.h-form-item').forEach((control) => {
      const dataset = control.dataset;
      Object.keys(dataset).forEach((rule) => {
        if (typeof this[`$${rule}`] === 'function') {
          let fieldStatus = this[`$${rule}`](control, dataset[rule]);
          if (!fieldStatus && validate) {
            validate = fieldStatus;
          }
          Validator._addStatusClass(control, fieldStatus);
        }
      })
    });
    return validate;
  }

  $required(control, _) {
    return Validator._getValue(control).length !== 0;
  }

  static _getValue(control) {
    for (let input = _$(control, 'input'); input;) {
      return input.value;
    }
    return '';
  }

  static _addStatusClass(control, status) {
    const classes = {false: 'h-validate-failure', true: 'h-validate-success'};
    if (control.classList.contains(classes[!status])) {
      control.classList.remove(classes[!status]);
    }
    if (!control.classList.contains(classes[status])) {
      control.classList.add(classes[status]);
    }
  }
}

class Sidebar {
  constructor(wrapper, toggleClass) {
    this.wrapper = wrapper;
    this.toggleClass = 'h-sidebar-toggle';
    this.sidebar = _$('.h-common-sidebar');
    this.control = _$('.h-sidebar-control');
  }
  init() {
    _$on(this.control, 'click', () => {
      this._toggle();
    });

    _$on('.h-common-sidebar', 'click', () => {
      this._toggle();
    });
  }
  _toggle() {
    if (!this.sidebar.classList.contains(this.toggleClass)) {
      this.sidebar.classList.toggle(this.toggleClass);
      setTimeout(() => this.wrapper.classList.toggle(this.toggleClass), 75)
    } else {
      this.wrapper.classList.toggle(this.toggleClass);
      setTimeout(() => this.sidebar.classList.toggle(this.toggleClass), 75)
    }
  }
}
