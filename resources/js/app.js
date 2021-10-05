/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Bouncer from "./import/bouncer.polyfills.min";

Vue = window.Vue = require('vue/dist/vue.esm.browser.min').default;


// Vue.use(SlimSelect);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import { Fancybox } from "@fancyapps/ui";



import VCalendar from "v-calendar";
Vue.use(VCalendar);

Vue.component('v-init', require('./components/InitComponent').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('v-select', require('./components/SelectComponent.vue').default);
Vue.component('v-custom-calendar', require('./components/CustomCalendarComponent').default);
Vue.component('v-time', require('./components/TimeComponent').default);
Vue.component('v-humans', require('./components/HumansComponent').default);
Vue.component('v-incdec', require('./components/IncdecComponent').default);
Vue.component('v-calculator', require('./components/CalculatorComponent').default);
Vue.component('v-custom-search', require('./components/CustomSearchComponent').default);
Vue.component('v-language-select', require('./components/LanguageSelectComponent').default);
Vue.component('v-currency-select', require('./components/CurrencySelectComponent').default);


// include ../../blocks/modules/calculator/select/select
// include ../../blocks/modules/calculator/calendar/calendar
// include ../../blocks/modules/calculator/time/time
// include ../../blocks/modules/calculator/humans/humans
// include ../../blocks/modules/calculator/incdec/incdec

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



const app = new Vue({
    el: '#app',

});
