/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

// import Bouncer from "./import/bouncer.polyfills.min";


Vue = window.Vue = require('vue/dist/vue.esm.browser.min').default;


import Vuex from 'vuex';

window.Vuex = Vuex;

Vue.use(Vuex);

// Vue.use(SlimSelect);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// import { Fancybox } from "@fancyapps/ui";

import store from "./store/index";
import VCalendar from "v-calendar";
Vue.use(VCalendar);

Vue.component('v-init', require('./components/InitComponent').default);
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('v-select', require('./components/SelectComponent.vue').default);
Vue.component('v-custom-calendar', require('./components/CustomCalendarComponent').default);
Vue.component('v-time', require('./components/TimeComponent').default);
Vue.component('v-humans', require('./components/HumansComponent').default);
Vue.component('v-incdec', require('./components/IncdecComponent').default);
Vue.component('v-calculator', require('./components/CalculatorComponent').default);
Vue.component('v-custom-search', require('./components/CustomSearchComponent').default);
Vue.component('v-language-select', require('./components/LanguageSelectComponent').default);
Vue.component('v-currency-select', require('./components/CurrencySelectComponent').default);

Vue.config.devtools = true;

const app = new Vue({
    el: '#app',
    store: new Vuex.Store(store)
});
