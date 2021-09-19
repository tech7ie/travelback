import Vue from "vue/dist/vue.esm.browser.min";

console.log('mounted');
new Vue({
    el: "#lang-switch",
    data: {},
    mounted() {
        console.log('mounted');
        document.querySelector(".js-menu-burger").addEventListener("click", function() {
            document.querySelector(".js-menu-burger").classList.toggle("--active");
            document.querySelector(".header").classList.toggle("--active");
        });
        document.getElementById("lang-switch").addEventListener("change", function(e) {
            console.log(e);
        });
    },
    computed: {},
    methods: {}
});

// import clickOutside from "../../../js/helper/outsideClick";
//
// let menuOpenBtn = document.querySelector(".js-menu-burger");
// let hederElement = document.querySelector(".header");
//
// menuOpenBtn.addEventListener("click", function() {
//     menuOpenBtn.classList.toggle("--active");
//     hederElement.classList.toggle("--active");
// });

// clickOutside(hederElement, function(type) {
//     if(type) {
//         menuOpenBtn.classList.add("--active");
//         hederElement.classList.add("--active");
//     }  else {
//         menuOpenBtn.classList.remove("--active");
//         hederElement.classList.remove("--active");
//     }
// });
