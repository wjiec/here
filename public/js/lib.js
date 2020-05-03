import selector from "./selector";

export const _$ = selector.$;
export const _$$ = selector.$$;
export const _$on = selector.$on;


export class Validator {
  constructor(form) {
    this.form = form;
    selector.$(this.form, 'input', () => this.validate());
  }
  validate() {
    let validate = true;
    selector.$$(this.form, '.h-form-item').forEach((control) => {
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
    let input = selector.$(control, 'input');
    if (!input) {
      input = selector.$(control, 'textarea');
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

export class Sidebar {
  constructor(wrapper) {
    this.wrapper = wrapper;
    this.toggleClass = 'h-sidebar-toggle';
    this.sidebar = selector.$('.h-common-sidebar');
    this.control = selector.$('.h-sidebar-control');
  }
  init() {
    selector.$on(this.control, 'click', () => {
      this.$toggle();
    });

    selector.$on('.h-common-sidebar', 'click', (e) => {
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

export class BackToTop {
  constructor(offset, duration) {
    this.offset = offset;
    this.scrolling = false;
    this.duration = duration;
    this.handler = selector.$('.h-widget-back-to-top-container');
  }
  init() {
    selector.$on(window, 'scroll', () => {
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
    selector.$on(this.handler, 'click', (e) => {
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

export class CommentReplier {
  constructor(container) {
    this.container = container;
    this.input = selector.$('#comment');
    this.parent = selector.$('#comment-parent');
  }
  init() {
    selector.$on(this.container, 'click', (e) => {
      const target = e.target.parentNode;
      const commentId = target.dataset['commentId'];
      if (commentId) {
        const quoteLines = this.$getQuoteLines(commentId);
        if (quoteLines.length !== 0) {
          this.$quoteContent(['>', ...quoteLines, ''].join('\n> ') + '\n\n', commentId);
        }
      }
    });
    selector.$on(this.input, 'input', (e) => {
      if (e.target.value.length === 0) {
        this.parent.value = 0;
      }
    })
  }
  $getQuoteLines(commentId) {
    const body = selector.$(`#comment-${commentId} .h-article-comment-body`);
    return body ? body.innerText.split('\n') : [];
  }
  $quoteContent(body, id) {
    this.input.value = body;
    this.input.focus();
    this.parent.value = id;
  }
}

export class Forbidden {
  constructor() {
    this.form = selector.$('form[data-disabled]')
  }
  init() {
    if (this.form) {
      const control = selector.$$(this.form, 'input');
      const textarea = selector.$$(this.form, 'textarea');
      const button = selector.$$(this.form, 'button');
      [...control, ...textarea, ...button].forEach((control) => {
        control.disabled = true;
      });
    }
  }
}

export class Menu {
  constructor(menu) {
    this.menu = menu;
  }
  init() {
    this.$activateMenu();
    selector.$on(this.menu, 'click', (e) => {
      const targetTag = e.target.tagName.toLowerCase();
      if (targetTag !== 'p' && targetTag !== 'i') {
        return;
      }
      const targetParent = e.target.parentNode;
      if (targetParent && targetParent.tagName.toLowerCase() === 'a') {
        return;
      }

      const paths = e['path'] || [];
      paths.forEach((el) => {
        if (el.classList && el.classList.contains('h-menu-has-folder')) {
          this.$toggleSubMenu(el);
        }
      });
    });
  }
  $toggleSubMenu(el) {
    el.classList.toggle('h-menu-open');

    const sub = selector.$(el, '.h-admin-sub-menu');
    if (sub.dataset['opened']) {
      sub.style.height = '';
      sub.dataset['opened'] = '';
    } else {
      const count = selector.$$(sub, '.h-admin-menu-item').length;
      sub.style.height = `${count * 56}px`;
      sub.dataset['opened'] = 'opened';
    }
  }
  $activateMenu() {
    selector.$$(this.menu, '[data-open]').forEach((el) => {
      if (el.dataset && el.dataset.open === 'yes') {
        this.$toggleSubMenu(el);
      }
      delete el.dataset.open;
    });
  }
}
