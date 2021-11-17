<template>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";

import Swiper from "swiper";

// let partenersSlider = new Swiper(".partners-slider", {
//     slidesPerView: "auto",
//     spaceBetween: 47,
//     loop: true,
//     breakpoints: {
//         0: {
//             spaceBetween: 15,
//         },
//         570: {
//             spaceBetween: 47,
//         }
//     }
// });

export default Vue.component("v-init", {
    props: {
        auth: false,
    },
    mounted() {

        let menuOpenBtn = document.querySelector(".js-menu-burger");
        let hederElement = document.querySelector(".header");

        menuOpenBtn.addEventListener("click", function() {
            menuOpenBtn.classList.toggle("--active");
            hederElement.classList.toggle("--active");
        });


        if(document.location.hash === '#login'){
            document.getElementById('auth_button').click()
        }
        new Swiper(".partners-slider", {
            slidesPerView: "auto",
            spaceBetween: 47,
            loop: false,
            breakpoints: {
                0: {
                    spaceBetween: 15,
                },
                570: {
                    spaceBetween: 47,
                }
            }
        });

        new Swiper(".sliderhome-slider", {
            slidesPerView: "auto",
            spaceBetween: 47,
            loop: true,
            breakpoints: {
                0: {
                    spaceBetween: 19,
                },
                570: {
                    spaceBetween: 58,
                }
            }
        });

    }
});
</script>
