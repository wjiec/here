//
// This file is part of here
//

export default class AutoRedirect {
  constructor(form) {
    this.form = form;
  }

  attach() {
    if (typeof this.form.elem.dataset.errorForm === 'string') {
      this.form.elem.submit()
    }
  }
}
