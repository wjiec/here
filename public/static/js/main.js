//
// This file is part of here
//
import ready from "./dom/ready";
import Selector from "./dom/selector";
import Validator from "./form/validator";

ready(() => {
  new Selector('form').each((s) => {
    new Validator(s).attach();
  });
});
