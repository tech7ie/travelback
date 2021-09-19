import Vue from "vue/dist/vue.esm.browser.min";
import initValidation from "../calculator/validator";
import Glide from "@glidejs/glide";
import { Controls } from "@glidejs/glide/dist/glide.modular.esm";
import debounce from "lodash.debounce";

require("../calculator/select/select");
require("../calculator/calendar/calendar");
require("../calculator/time/time");
require("../calculator/humans/humans");
require("../calculator/incdec/incdec");
require("../calculator/withstops/withstops");
require("../calculator/article/article");

new Vue({
  el: "#psearch",
  data: {
    price: 0,
    auto: [
      {
        type: "sedan",
        title: "Sedan",
        name: "Skoda Superb",
        img: "sedan.png",
        passagers: "1-3",
        lugguage: "3",
        minPassagers: 1,
        maxPassagers: 3,
        minLugguage: 1,
        maxLugguage: 3,
      },
      {
        type: "mvp",
        title: "MPV",
        name: "Volkswagen Sharan",
        img: "sharan.png",
        passagers: "4",
        lugguage: "4",
        minPassagers: 4,
        maxPassagers: 4,
        minLugguage: 4,
        maxLugguage: 4,
      },
      {
        type: "suv",
        title: "SUV",
        name: "KIA Sportage",
        img: "sportage.png",
        passagers: "4-5",
        lugguage: "5",
        minPassagers: 4,
        maxPassagers: 5,
        minLugguage: 5,
        maxLugguage: 5,
      },
      {
        type: "van",
        title: "Van",
        name: "Mercedes Vito",
        img: "vito.jpg",
        passagers: "5-7",
        lugguage: "7",
        minPassagers: 5,
        maxPassagers: 7,
        minLugguage: 5,
        maxLugguage: 7,
      },
      {
        type: "shared",
        title: "Shared",
        name: "Shuttle - IVECO Tourer",
        img: "vito.jpg",
        passagers: "8",
        lugguage: "8",
        minPassagers: 8,
        maxPassagers: 8,
        minLugguage: 8,
        maxLugguage: 8,
      },
      {
        type: "minibus",
        title: "Minibus",
        name: "Sprinter Tourer",
        img: "sprinter.png",
        passagers: "16",
        lugguage: "16",
        minPassagers: 9,
        maxPassagers: 16,
        minLugguage: 9,
        maxLugguage: 16,
      },
      {
        type: "minibus",
        title: "Minibus",
        name: "Mercedes Sprinter",
        img: "minibus.png",
        passagers: "16",
        lugguage: "16",
        minPassagers: 9,
        maxPassagers: 16,
        minLugguage: 9,
        maxLugguage: 16,
      },
      {
        type: "bus",
        title: "Bus",
        name: "SETRA",
        img: "bus.png",
        passagers: "50",
        lugguage: "50",
        minPassagers: 17,
        maxPassagers: 50,
        minLugguage: 17,
        maxLugguage: 50,
      }
    ],
    withstopsList: [],
    withstopsListPrce: 0,
    articleList: [
      {
        id: 1,
        img: "/img/search-article-1.jpg",
        title: "Los Angeles",
        text: "Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will",
        price: 82
      }, {
        id: 2,
        img: "/img/search-article-2.jpg",
        title: "Los Angeles",
        text: "Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will",
        price: 82
      }
    ],
    passangers: [],
    glide: {}
  },
  mounted() {
    initValidation(".js-psearch-from");

    if (window.matchMedia("(max-width: 900px)").matches) {
      this.glideMount();
    }

    window.addEventListener("resize", debounce(() => {
      if (window.matchMedia("(max-width: 900px)").matches) {
        this.glideMount();
      } else {
        let glideEl = document.querySelector(".glide");
        if(!glideEl) return false;
        if(glideEl.classList.contains("glide--slider")) {
          this.glideDestroy();
        }
      }
    }, 500));
  },
  methods: {
    glideMount() {
      this.glide = new Glide(".glide").mount({ Controls });
    },
    glideDestroy() {
      this.glide.destroy();
    },
    removeWithstopsItem(item) {
      this.withstopsList.splice(this.withstopsList.indexOf(item), 1);
    },
    returnPersone(e) {
      this.passangers = [];
      // console.log(e.passangers, e.lugguage);
      // this.$nextTick(() => {
      //   if(e.passangers >= 1 && e.passangers <= 4 || e.lugguage >= 1 && e.lugguage <= 4) {
      //     console.log("sedan");
      //   } else {
      //     console.log("other");
      //   }
      // });
      // e.lugguage >= item.minLugguage && e.lugguage >= item.maxLugguage
      this.auto.forEach(item => {
        let pas = e.passangers >= item.minPassagers && e.passangers <= item.maxPassagers;
        let lug = e.lugguage >= item.minLugguage && e.lugguage <= item.maxLugguage;
        let result = false;

        if(e.passangers > e.lugguage) {
          if(pas) {
            result = true;
            // console.log(item.type);
          }
        } else {
          if(lug) {
            result = true;
            // console.log(item.type)
          }
        }

        if(result) this.passangers.push(item);
      });
    },
    addNewStopItem(item, type) {
      let exists = this.withstopsList.find(val => {
        return val.id === item.id;
      });

      if(type) {
        this.withstopsList.splice(this.withstopsList.indexOf(item), 1);
      } else {
        if(!exists) this.withstopsList.push(item);
      }
    }
  },
  watch: {
    withstopsList() {
      this.withstopsListPrce = 0;

      this.withstopsList.forEach(item => {
        this.withstopsListPrce += item.price;
      });
    }
  }
});
