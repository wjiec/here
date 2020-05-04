export default {
    $(target, selector) {
        if (!selector) {
            [selector, target] = [target, document];
        }
        return target.querySelector(selector)
    },
    $$(target, selector) {
        if (!selector) {
            [selector, target] = [target, document];
        }
        return target.querySelectorAll(selector)
    },
    $on(target, e, callback) {
      if (typeof target === 'string') {
        target = document.querySelector(target)
      }

      if (target) {
        return target.addEventListener(e, callback, true)
      }
    }
}
