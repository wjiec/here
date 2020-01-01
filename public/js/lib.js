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

  if (target) {
    return target.addEventListener(e, callback, true)
  }
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
    let input = _$(control, 'input');
    if (!input) {
      input = _$(control, 'textarea');
    }
    return input ? input.value : '';
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
  constructor(wrapper) {
    this.wrapper = wrapper;
    this.toggleClass = 'h-sidebar-toggle';
    this.sidebar = _$('.h-common-sidebar');
    this.control = _$('.h-sidebar-control');
  }
  init() {
    _$on(this.control, 'click', () => {
      this.$toggle();
    });

    _$on('.h-common-sidebar', 'click', (e) => {
      if (e.target.tagName.toLowerCase() !== 'a') {
        this.$toggle();
      }
    });
  }
  $toggle() {
    this.control.style.animation = '';
    if (!this.sidebar.classList.contains(this.toggleClass)) {
      this.sidebar.classList.toggle(this.toggleClass);
      setTimeout(() => this.wrapper.classList.toggle(this.toggleClass), 75)
    } else {
      this.wrapper.classList.toggle(this.toggleClass);
      setTimeout(() => this.sidebar.classList.toggle(this.toggleClass), 75)
    }
  }
}

class BackToTop {
  constructor(offset, duration) {
    this.offset = offset;
    this.scrolling = false;
    this.duration = duration;
    this.handler = _$('.h-widget-back-to-top-container');
  }
  init() {
    _$on(window, 'scroll', () => {
      if (!this.scrolling) {
        this.scrolling = true;
        window.requestAnimationFrame(() => {
          const windowTop = window.scrollY || document.documentElement.scrollTop;
          if (windowTop > this.offset) {
            this.handler.classList.add('widget-is-visible');
          } else {
            this.handler.classList.remove('widget-is-visible');
          }
          this.scrolling = false;
        })
      }
    });
    _$on(this.handler, 'click', (e) => {
      e.preventDefault();

      let currentTimestamp = null;
      const start = window.scrollY || document.documentElement.scrollTop;
      const smooth = (timestamp) => {
        currentTimestamp = currentTimestamp ? currentTimestamp : timestamp;
        let progress = timestamp - currentTimestamp;
        if (progress > this.duration) {
          progress = this.duration;
        }
        window.scrollTo(0, BackToTop.$easeInOut(progress, start, -start, this.duration));
        if (progress < this.duration) {
          window.requestAnimationFrame(smooth);
        }
      };
      window.requestAnimationFrame(smooth);
    });
  }
  static $easeInOut(t, b, c, d) {
      t /= d / 2;
      if (t < 1) {
        return c / 2 * t * t + b;
      }

      t -= 1;
      return -c / 2 * (t * (t - 2) - 1) + b;
  }
}
