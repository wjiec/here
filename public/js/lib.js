class Validator {
  constructor(form) {
    this.form = form;
    this.form.addEventListener('input', () => {
      this.validate();
    })
  }

  validate() {
    let validate = true;
    this.form.querySelectorAll('.h-form-item').forEach((control) => {
      const dataset = control.dataset;
      Object.keys(dataset).forEach((rule) => {
        if (typeof this[`_${rule}`] === 'function') {
          let fieldStatus = this[`_${rule}`](control, dataset[rule]);
          if (!fieldStatus && validate) {
            validate = fieldStatus;
          }
          Validator._addStatusClass(control, fieldStatus);
        }
      })
    });
    return validate;
  }

  _required(control, _) {
    return Validator._getValue(control).length !== 0;
  }

  static _getValue(control) {
    const input = control.querySelector('input');
    if (input) {
      return input.value
    }
    return "";
  }

  static _addStatusClass(control, status) {
    const classes = {false: 'h-validate-failure', true: 'h-validate-success'};
    if (control.classList.contains(classes[!status])) {
      control.classList.remove(classes[!status])
    }
    if (!control.classList.contains(classes[status])) {
      control.classList.add(classes[status])
    }
  }
}
