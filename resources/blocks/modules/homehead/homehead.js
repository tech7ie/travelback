import Vue from "vue/dist/vue.esm.browser.min";
import initValidation from "../calculator/validator";
require("../calculator/select/select");
require("../calculator/calendar/calendar");
require("../calculator/time/time");
require("../calculator/humans/humans");
require("../calculator/incdec/incdec");

new Vue({
  el: "#homehead-form",
  data: {},
  mounted() {
    initValidation(".js-homehead-form");
  },
  computed: {},
  methods: {}
});
