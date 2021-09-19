import Swiper from "swiper";

let sliderhomeSlider = new Swiper(".sliderhome-slider", {
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

