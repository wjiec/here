//
// This file is part of here
//

class AsyncControlValidator {
  constructor(el) {
    this.el = el;
    this.ctl = el.query('[name]');

    if (this.ctl.elem) {
      this.ctl.bind('blur', () => {
        this.validate().catch(() => {});
      });
    }
  }

  validate() {
    return new Promise(((resolve, reject) => {
      if (!this.ctl.elem) {
        return resolve()
      }

      let status = true;
      Object.keys(this.el.elem.dataset).forEach((k) => {
        if (this[`$${k}`] && !this[`$${k}`]()) {
          status = false;
        }
      });

      if (status) {
        this.el.elem.classList.add('is-success');
        this.el.elem.classList.remove('is-failure');
        resolve();
      } else {
        this.el.elem.classList.remove('is-success');
        this.el.elem.classList.add('is-failure');
        reject();
      }
    }));
  }

  $required() {
    return this.ctl.elem.value.length !== 0;
  }
}


export default class Validator {
  constructor(form) {
    this.form = form;
    this.validators = []
  }

  attach() {
    this.form.query('.h-form-item').each((control) => {
      this.validators.push(new AsyncControlValidator(control));
    });

    this.form.bind('submit', (e) => {
      this.validate(e)
    })
  }

  validate(e) {
    Promise.all(this.validators.map((v) => v.validate())).catch(() => {
      e.preventDefault();
    });
  }
}
