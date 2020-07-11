//
// This file is part of here
//
import ready from "./dom/ready";
import Selector from "./dom/selector";
import Validator from "./form/validator";
import AutoRedirect from "./form/auto_redirect";

ready(() => {
  new Selector('form').each((s) => {
    new AutoRedirect(s).attach();
    new Validator(s).attach();
  });
});
