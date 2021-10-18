<template>
    <section class="psearch" id="psearch">
        <form @submit="goToOrder" class="container psearch__wrap js-psearch-from_" data-submit="psearchSubmit">
            <div class="psearch__form">
                <!--                {{orderRoute}}-->
                <!--                {{current}}-->
                <div class="psearch__head">
                    <h2>{{ orderRoute.from }}
                        <svg class="icon">
                            <use xlink:href="/img/sprites/sprite.svg#arrow-long"></use>
                        </svg>
                        {{ orderRoute.to }}
                    </h2>
<!--                    {{'getExtraMinutes'}}-->
                    <em>Estimated arrival {{ orderRoute.route_end | moment("add", getExtraMinutes + " m", "h:mm:ss A")}}</em>
<!--                    Estimated arrival 12:45 PM-->
                </div>
                <div class="calc">
                    <div class="custom-select">
                        <div class="custom-select__item" :class="{'--active': openedFrom }">
                            <div class="custom-select__head" data-input-parent :class="{error: errorFrom}">
                                <input
                                    name="from"
                                    placeholder="From"
                                    @input="inputFrom"
                                    required="required"
                                    type="search"
                                    v-model="orderRoute.from"
                                    autocomplete="off"
                                    @keyup="openedFrom = true"
                                    @blur="toggle"
                                />
                            </div>
                            <div class="custom-select__options" :class="{ '--opened': openedFrom }">
                                <div class="custom-select__option" @click="selectFrom(item)" v-for="(item, index) in filteredRoutes" :key="index">
                                    <b>{{ item.from_city }}</b>
                                    <em>{{ item.from_country }}</em>
                                </div>
                            </div>
                        </div>
                        <div class="custom-select__change" @click="change">
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#icn-arrows2"></use>
                            </svg>
                        </div>
                        <div class="custom-select__item" :class="{'--active': openedTo }">
                            <div class="custom-select__head" data-input-parent :class="{error: errorTo}">
                                <input
                                    name="to"
                                    placeholder="To"
                                    @input="inputTo"
                                    required="required"
                                    type="search"
                                    v-model="orderRoute.to"
                                    autocomplete="off"
                                    @keyup="openedTo = true"
                                    @blur="toggle"
                                />
                            </div>
                            <div class="custom-select__options" :class="{ '--opened': openedTo }">
                                <div class="custom-select__option" @click="selectTo(item)" v-for="(item, index) in filteredRoutesTo" :key="index">
                                    <b>{{ item.to_city }}</b>
                                    <em>{{ item.to_country }}</em>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--                    <v-select :orderRoute={orderRoute} :filteredRoutes="filteredRoutes"></v-select>-->
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
                            <li class="glide__slide" v-for="(item, index) in getCurrentRoutePlaces" :key="index">
                                <v-article :addedPoint="addedPoint(item)" :data="item" :index="index" @return="addNewStopItem"></v-article>
                            </li>
                        </ul>
                    </div>
                    <div class="glide__bullets" data-glide-el="controls[nav]">
                        <button class="glide__bullet" v-for="(item, index) in articleList" :key="index" type="button" :data-glide-dir="'=' + index"></button>
                    </div>
                </div>
            </div>
            <div class="psearch__last">
                <div class="withstops" v-if="points.length"><em>With stops in</em>
                    <div class="withstops__list">
                        <v-withstops v-for="(item, index) in points" @update_time="updateWithstopsItem" @remove="removeWithstopsItem(item)" :key="index" :data="item"></v-withstops>
                    </div>
                </div>
                <div class="yourride">
                    <div class="yourride__head">
                        <h3>Your ride</h3>
                        <a data-fancybox data-src="#select-ride" href="#">Other cars</a>
                    </div>
                    <div class="yourride__selected" :class="{two: passangers.length &gt; 1}">
                        <div class="tickets__footer">
                            <i>
                                <img  v-for="(item, index) in passangers" :key="index" :src="'/' + item.image" :alt="item.title">
                            </i>
                            <div v-for="(item, index) in passangers" :key="index" class="tickets__footer-info">
                                <header>
                                    <h4>{{ item.title }}</h4><em>{{ item.brand }}</em>
                                </header>
                                <div>
                                    <span>{{ item.places_min }} - {{ item.places_max }}</span>
                                    <svg class="icon">
                                        <use xlink:href="/img/sprites/sprite.svg#users"></use>
                                    </svg>
                                </div>
                                <div>
                                    <span>{{ item.luggage }}</span>
                                    <svg class="icon">
                                        <use xlink:href="/img/sprites/sprite.svg#suitecase"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button>
                                <span>BUY FOR {{ (totalCarPrice + withstopsListPrce).toFixed(2) }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="yourride__selected extra" v-if="passangers_extra.length > 0">
                        <div style="cursor:pointer; color: #03acd1" class="tickets__footer" v-for="(item, index) in passangers_extra" :key="index" @click="setCar(item)">
                            <i>
                                <img :src="'/' + item.image" :alt="item.title">
                            </i>
                            <div class="tickets__footer-info">
                                <div>
                                    Upgrade to a luxury sedan for €{{((totalCarPrice + (item.places_max * current.price)) - (totalCarPrice + withstopsListPrce)).toFixed(2)}}
                                </div>
                            </div>
                        </div>
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

        <div class="popup --xl" id="select-ride">
            <form class="popup__wrap">
                <h3>Select your ride</h3>
                <div class="popup-select-rider">
                    <input id="select-auto-1" type="radio" name="select-ride" checked>
                    <label for="select-auto-1">
                        <div class="tickets__footer"><i><img src="img/sedan.png" alt="sedan"></i>
                            <div class="tickets__footer-info">
                                <h4>Luxury sedan</h4><em>Mercedes Benz E-Class</em>
                                <div><span>1-3</span>
                                    <svg class="icon">
                                        <use xlink:href="img/sprites/sprite.svg#users"></use>
                                    </svg>
                                </div>
                                <div><span>3x</span>
                                    <svg class="icon">
                                        <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="tickets__footer-price"><b>€929</b></div>
                        </div>
                    </label>
                    <input id="select-auto-2" type="radio" name="select-ride">
                    <label for="select-auto-2">
                        <div class="tickets__footer"><i><img src="img/sedan.png" alt="sedan"></i>
                            <div class="tickets__footer-info">
                                <h4>Luxury sedan</h4><em>Mercedes Benz E-Class</em>
                                <div><span>1-3</span>
                                    <svg class="icon">
                                        <use xlink:href="img/sprites/sprite.svg#users"></use>
                                    </svg>
                                </div>
                                <div><span>3x</span>
                                    <svg class="icon">
                                        <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="tickets__footer-price"><b>€929</b></div>
                        </div>
                    </label>
                </div>
                <button class="btn-submit --simple --no-opacity --sm"><span>Save</span></button>
            </form>
        </div>
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

import {mapState, mapMutations} from 'vuex'

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
    props: {
        routes: [],
        errors: [],
        current: false,
        current_route_places: [],
        debug: [],
    },
    data() {
        return {
            price: 0,
            auto: [
                {
                    type: "sedan",
                    title: "Sedan",
                    name: "Skoda Superb",
                    img: "sedan.png",
                    passengers: "1-3",
                    luggage: "3",
                    minPassengers: 1,
                    maxPassengers: 3,
                    minLuggage: 1,
                    maxLuggage: 3,
                },
                {
                    type: "mvp",
                    title: "MPV",
                    name: "Volkswagen Sharan",
                    img: "sharan.png",
                    passengers: "4",
                    luggage: "4",
                    minPassengers: 4,
                    maxPassengers: 4,
                    minLuggage: 4,
                    maxLuggage: 4,
                },
                {
                    type: "suv",
                    title: "SUV",
                    name: "KIA Sportage",
                    img: "sportage.png",
                    passengers: "4-5",
                    luggage: "5",
                    minPassengers: 4,
                    maxPassengers: 5,
                    minLuggage: 5,
                    maxLuggage: 5,
                },
                {
                    type: "van",
                    title: "Van",
                    name: "Mercedes Vito",
                    img: "vito.jpg",
                    passengers: "5-7",
                    luggage: "7",
                    minPassengers: 5,
                    maxPassengers: 7,
                    minLuggage: 5,
                    maxLuggage: 7,
                },
                {
                    type: "shared",
                    title: "Shared",
                    name: "Shuttle - IVECO Tourer",
                    img: "vito.jpg",
                    passengers: "8",
                    luggage: "8",
                    minPassengers: 8,
                    maxPassengers: 8,
                    minLuggage: 8,
                    maxLuggage: 8,
                },
                {
                    type: "minibus",
                    title: "Minibus",
                    name: "Sprinter Tourer",
                    img: "sprinter.png",
                    passengers: "16",
                    luggage: "16",
                    minPassengers: 9,
                    maxPassengers: 16,
                    minLuggage: 9,
                    maxLuggage: 16,
                },
                {
                    type: "minibus",
                    title: "Minibus",
                    name: "Mercedes Sprinter",
                    img: "minibus.png",
                    passengers: "16",
                    luggage: "16",
                    minPassengers: 9,
                    maxPassengers: 16,
                    minLuggage: 9,
                    maxLuggage: 16,
                },
                {
                    type: "bus",
                    title: "Bus",
                    name: "SETRA",
                    img: "bus.png",
                    passengers: "50",
                    luggage: "50",
                    minPassengers: 17,
                    maxPassengers: 50,
                    minLuggage: 17,
                    maxLuggage: 50,
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
            passangers_extra: [],
            glide: {},
            orderRoute: {
                from: null,
                to: null,
                passengers: null,
                luggage: null,
                route_start: null,
                route_end: null,
            },
            openedFrom: false,
            openedTo: false,
            selectedFrom: "",
            errorFrom: false,
            selectedTo: "",
            errorTo: false,
            firstStart: false,
        }
    },
    created() {
        this.firstStart = true;
        console.log(this.cart);
    },
    mounted() {
        initValidation(".js-psearch-from");

        if (this.current) {
            this.orderRoute.from = this.current.from_city.name
            this.orderRoute.to = this.current.to_city.name
            this.orderRoute.route_start = this.current.route_start
            this.orderRoute.route_end = this.current.route_end
            this.price = this.current.price
            this.$store.commit('setRoute', this.current);
        }

        this.updatePrice()


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
        setCar(car){
            this.passangers = [car]
            this.passangers_extra = []
        },
        goToOrder(e) {
            e.preventDefault()
            console.log(e);

            let selected = {
                orderRoute: this.orderRoute,
                price: (this.totalCarPrice + this.withstopsListPrce).toFixed(2),
                passangers: this.passangers,
                extraMinutes: this.getExtraMinutes,
            }
            this.$store.commit('setSelected', selected);
            console.log('selected: ', selected);
            window.location.href = this.getOrderUrl();
        },
        getOrderUrl() {
            return '/' + window.App.language + '/order'
        },
        addedPoint(item) {
            let issetPoint = false


            this.points.forEach(i => {
                if (i.id === item.id) {
                    issetPoint = true
                }
            })

            return issetPoint
        },
        glideMount() {
            this.glide = new Glide(".glide").mount({Controls});
        },
        glideDestroy() {
            this.glide.destroy();
        },
        removeWithstopsItem(item) {
            this.$store.commit('removePoint', item);

            // this.withstopsList.splice(this.withstopsList.indexOf(item), 1);
        },
        updateWithstopsItem(data) {
            this.$store.commit('updatePointTime', data);
            this.updatePrice()

            // this.withstopsList.splice(this.withstopsList.indexOf(item), 1);
        },
        getCarsOrdered() {
            return this.current.cars.sort(function (a, b) {
                if (a.places_max > b.places_max) {
                    return 1;
                }
                if (a.places_max < b.places_max) {
                    return -1;
                }
                // a должно быть равным b
                return 0;
            });
        },
        returnPersone(e) {
            this.passangers = [];
            this.passangers_extra = [];
            let current_passengers = e.passengers
            let current_luggage = e.luggage

            let total_passengers = {
                places_min: 0,
                places_max: 0,
            }
            let total_luggage = {
                luggage: 0
            }
            this.getCarsOrdered().forEach(item => {
                let pas_ex = current_passengers > total_passengers.places_max;
                let lug_ex = current_luggage > total_luggage.luggage;
                //
                // if (pas && lug) {
                //     this.passangers.push(item);
                //     total_passengers.places_max += item.places_max
                //     total_passengers.places_min += item.places_min
                //     total_luggage.luggage += item.luggage;
                // }

                let pas = e.passangers >= item.places_min && e.passangers <= item.places_max;
                let lug = e.luggage >= item.places_min && e.luggage <= item.places_max;
                let result = false;

                // console.log('pas: ',pas);
                // console.log('lug: ',lug, '1: ', e.luggage , '2: ', item.luggage );
                if(e.passangers > e.luggage) {
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

                console.log(item.title + ' - ' + item.brand, '-> ', result);
                if(result && (pas_ex && lug_ex)){
                    this.passangers.push(item);
                    total_passengers.places_max += item.places_max
                    total_passengers.places_min += item.places_min
                    total_luggage.luggage += item.luggage;

                }else if(result && this.passangers_extra.length === 0){
                    this.passangers_extra.push(item);
                }
            });

            console.log(this.passangers);
            console.log(this.current.cars);
        },
        addNewStopItem(item, type) {
            let exists = this.withstopsList.find(val => {
                return val.id === item.id;
            });
            if (!exists) {
                item['extra'] = 0
                console.log('point:', item);
                this.withstopsList.push(item);
                this.$store.commit('addPoint', item);
            } else {
                this.withstopsList.splice(this.withstopsList.indexOf(item), 1);

                this.$store.commit('removePoint', item);
            }
        },
        updateError() {
            // this.errorFrom = this.selectedFrom.length <= 2;
            // this.errorTo = this.selectedTo.length <= 2;
        },
        selectFrom(item) {
            this.orderRoute.from = item.from_city;
            this.updateError();
        },
        inputFrom() {
            this.updateError();
            this.orderRoute.to = '';
        },
        selectTo(item) {
            this.orderRoute.to = item.to_city;
            this.updateError();
        },
        inputTo() {
            this.updateError();
        },
        change() {
            let from = this.selectedFrom;
            let to = this.selectedTo;
            this.selectedFrom = to;
            this.selectedTo = from;
            this.updateError();
        },
        toggle() {
            setTimeout(() => {
                this.openedFrom = false;
                this.openedTo = false;
            }, 300);
        },
        updatePrice() {
            this.withstopsListPrce = 0;
            this.points.forEach(item => {
                this.withstopsListPrce += (item.price + ((item.extra / 30) * (item.extra_durations / 2)));
            });
        }
    },
    computed: {
        ...mapState({
            cart: store => store.cart,
            count: store => store.count,
            route: store => store.route,
            points: store => store.points,
        }),
        getExtraMinutes(){
            let extraMinutes = 0;
            console.log(this.points);
            this.points.forEach(item => {
                console.log(item.extra);
                extraMinutes += item.extra;
            });
            return extraMinutes;
        },
        totalCarPrice() {
            let places = 0;
            this.passangers.forEach(p => {
                console.log('totalCarPrice', p);
                places += p.places_max
            })
            return places * this.current.price
        },
        getCurrentRoutePlaces() {
            return this.current_route_places

            // return this.current_route_places.filter(i => {
            //     return this.points.filter(p => {
            //         return p.id === i.id
            //     }).length === 0
            // })
        },
        ampm() {
            return this.pm ? "PM" : "AM";
        },
        filteredRoutes() {
            return this.routes.filter(r => {
                return this.orderRoute.from.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
            })
        },
        filteredRoutesTo() {
            return this.routes.filter(r => {
                return this.orderRoute.from.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
            }).filter(r => {
                return this.orderRoute.to.length > 0 ? r.to_city.toLowerCase().indexOf(this.orderRoute.to.toLowerCase()) >= 0 : true;
            })
        }
    },
    watch: {
        points() {
            this.updatePrice()
        }
    }
});
</script>
