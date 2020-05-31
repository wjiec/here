//
// This file is part of here
//

let fns = [];
let isReady = false;

const ready = (fn) => {
  if (!isReady) {
    if (fn) {
      fns.push(fn);
    }
    return;
  }

  fns.forEach((f) => {
    window.setTimeout(f);
  })
};

const completed = () => {
  document.removeEventListener('DOMContentLoaded', completed);
  document.removeEventListener('load', completed);

  isReady = true;
  ready();
};

if (document.readyState !== 'loading') {
  window.setTimeout(ready);
} else {
  document.addEventListener('DOMContentLoaded', completed);
  document.addEventListener('load', completed);
}

export default ready;
