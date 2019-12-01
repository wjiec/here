class Validator {
  constructor(form) {
    this.form = form
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
          Validator.addStatusClass(control, fieldStatus);
        }
      })
    });
    return validate;
  }

  _required(control, _) {
    return Validator.getValue(control).length !== 0;
  }

  static getValue(control) {
    const input = control.querySelector('input');
    if (input) {
      return input.value
    }
    return "";
  }

  static addStatusClass(control, status) {
    const statusClass = `h-validate-${status ? 'success' : 'failure'}`;
    if (!control.classList.contains('statusClass')) {
      control.classList.add(statusClass);
    }
  }
}
