import clickOutside from "../../../js/helper/outsideClick";

let menuOpenBtn = document.querySelector(".js-menu-burger");
let hederElement = document.querySelector(".header");

menuOpenBtn.addEventListener("click", function() {
    menuOpenBtn.classList.toggle("--active");
    hederElement.classList.toggle("--active");
});

// clickOutside(hederElement, function(type) {
//     if(type) {
//         menuOpenBtn.classList.add("--active");
//         hederElement.classList.add("--active");
//     }  else {
//         menuOpenBtn.classList.remove("--active");
//         hederElement.classList.remove("--active");
//     }
// });
