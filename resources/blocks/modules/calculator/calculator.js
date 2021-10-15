import Vue from "vue/dist/vue.esm.browser.min";
import initValidation from "../calculator/validator";
require("./select/select");
require("./calendar/calendar");
require("./time/time");
require("./humans/humans");
require("./incdec/incdec");
require("./extrastops/extrastops");
require("./choosecar/choosecar");
require("./requirements/requirements");

new Vue({
  el: "#calculator",
  data: {
    extrastops: false,
    choosecar: false,
    requirements: false
  },
  methods: {
    toggle(item) {
      this[item] = !this[item];
    }
  },
  mounted() {
    initValidation(".js-calculator");
  },
});