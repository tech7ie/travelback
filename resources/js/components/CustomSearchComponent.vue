<template>
    <section class="psearch" id="psearch">
        <form class="container psearch__wrap js-psearch-from" data-submit="psearchSubmit">
            <div class="psearch__form">
                <div class="psearch__head">
                    <h2>Prague
                        <svg class="icon">
                            <use xlink:href="/img/sprites/sprite.svg#arrow-long"></use>
                        </svg>
                        Berlin
                    </h2>
                    <em>Estimated arrival 12:45 PM</em>
                </div>
                <div class="calc">
                    <v-select></v-select>
                    <div class="date-time">
                        <v-custom-calendar></v-custom-calendar>
                        <v-time></v-time>
                    </div>
                    <v-humans @return="returnPersone"></v-humans>
                </div>
            </div>
            <div class="psearch__other">
                <h3>Visit along the way</h3>
                <div class="glide">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <li class="glide__slide" v-for="(item, index) in articleList" :key="index">
                                <v-article :data="item" :index="index" @return="addNewStopItem"></v-article>
                            </li>
                        </ul>
                    </div>
                    <div class="glide__bullets" data-glide-el="controls[nav]">
                        <button class="glide__bullet" v-for="(item, index) in articleList" :key="index" type="button" :data-glide-dir="'=' + index"></button>
                    </div>
                </div>
            </div>
            <div class="psearch__last">
                <div class="withstops" v-if="withstopsList.length"><em>With stops in</em>
                    <div class="withstops__list">
                        <v-withstops v-for="(item, index) in withstopsList" @remove="removeWithstopsItem(item)" :key="index" :data="item"></v-withstops>
                    </div>
                </div>
                <div class="yourride">
                    <div class="yourride__head">
                        <h3>Your ride</h3><a href="#Other-cars">Other cars</a>
                    </div>
                    <div class="yourride__selected" :class="{two: passangers.length &gt; 1}">
                        <div class="tickets__footer">
                            <i>
                                <img v-for="(item, index) in passangers" :key="index" :src="'/img/cars/' + item.img" :alt="item.title">
                            </i>
                            <div class="tickets__footer-info" v-for="(item, index) in passangers" :key="index">
                                <header>
                                    <h4>{{ item.title }}</h4><em>{{ item.name }}</em>
                                </header>
                                <div><span>{{ item.passagers }}</span>
                                    <svg class="icon">
                                        <use xlink:href="/img/sprites/sprite.svg#users"></use>
                                    </svg>
                                </div>
                                <div><span>{{ item.lugguage }}</span>
                                    <svg class="icon">
                                        <use xlink:href="/img/sprites/sprite.svg#suitecase"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <button><span>BUY FOR {{ price + withstopsListPrce }}</span></button>
                    </div>
                    <div class="yourride__footer">
                        <ul>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#chat"></use>
                                </svg>
                            </i><span>Support 24/7</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#driver-2"></use>
                                </svg>
                            </i><span>English-speaking driver</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#disabled"></use>
                                </svg>
                            </i><span>Prepared for handicapped</span></li>
                        </ul>
                        <ul>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#car"></use>
                                </svg>
                            </i><span>Clean, comfortable car</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#bottle"></use>
                                </svg>
                            </i><span>Bottled water</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#undefined"></use>
                                </svg>
                            </i><span>From a to be service</span></li>
                        </ul>
                        <ul>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#little-kid"></use>
                                </svg>
                            </i><span>Child seats</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#smoking"></use>
                                </svg>
                            </i><span>No-smoking</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#paw"></use>
                                </svg>
                            </i><span>Pet friendly</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";
import initValidation from "../../../tripline-master/src/blocks/modules/calculator/validator";
import debounce from "lodash.debounce";
import Glide from "@glidejs/glide";
import {Controls} from "@glidejs/glide/dist/glide.modular.esm";
import Extrastops from "./ExtrastopsComponent";
import Extrasteps from "./ExtrastepsComponent";
import Choosecar from "./ChoosecarComponent";
import Requirements from "./RequirementsComponent";
import Withstops from "./WithstopsComponent";
import Article from "./ArticleComponent";

export default Vue.component("v-custom-search", {
    comments: {
        Extrastops,
        Extrasteps,
        Choosecar,
        Requirements,
        Withstops,
        Article
    },
    el: "#psearch",
    data() {
        return {
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
        }
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
                if (!glideEl) return false;
                if (glideEl.classList.contains("glide--slider")) {
                    this.glideDestroy();
                }
            }
        }, 500));
    },
    methods: {
        glideMount() {
            this.glide = new Glide(".glide").mount({Controls});
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

                if (e.passangers > e.lugguage) {
                    if (pas) {
                        result = true;
                        // console.log(item.type);
                    }
                } else {
                    if (lug) {
                        result = true;
                        // console.log(item.type)
                    }
                }

                if (result) this.passangers.push(item);
            });
        },
        addNewStopItem(item, type) {
            let exists = this.withstopsList.find(val => {
                return val.id === item.id;
            });

            if (type) {
                this.withstopsList.splice(this.withstopsList.indexOf(item), 1);
            } else {
                if (!exists) this.withstopsList.push(item);
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

</script>
