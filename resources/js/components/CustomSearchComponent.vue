<template>
    <section class="psearch" id="psearch">
        <form class="container psearch__wrap js-psearch-from">
            <input name="route" type="text" :value="parseInt(route_id)" hidden>
            <input type="number" :value="searchInvert" name="invert" hidden>

            <div class="psearch__form">
                <div class="psearch__head">
                    <h2>{{ orderRoute.from }}
                        <svg class="icon">
                            <use xlink:href="/img/sprites/sprite.svg#arrow-long"></use>
                        </svg>
                        {{ orderRoute.to }}
                    </h2>
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
                                    <b>{{ item.city }}</b>
                                    <em>{{ item.country }}</em>
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
                                    <b>{{ searchInvert ? item.from_city : item.to_city }}</b>
                                    <em>{{ searchInvert ? item.from_country : item.to_country }}</em>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--                    <v-select :orderRoute={orderRoute} :filteredRoutes="filteredRoutes"></v-select>-->
                    <div class="date-time">
                        <v-custom-calendar :d="data"></v-custom-calendar>
                        <v-time :h="hours" :m="minutes"></v-time>
                    </div>
                    <v-humans :data="{adults,childrens,luggage}" @return="returnPersone"></v-humans>
                </div>
            </div>
            <div class="psearch__other">
                <h3>{{ $t('Visit along the way') }}</h3>
                <div class="glide">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <li class="glide__slide" v-for="(item, index) in getCurrentRoutePlaces" :key="index">
                                <v-article :addedPoint="addedPoint(item)" :data="item" :index="index" @return="addNewStopItem">
                                    <div class="glide__img-wrap"></div>
                                </v-article>
                            </li>
                        </ul>
                    </div>
                    <div class="glide__bullets" data-glide-el="controls[nav]">
                        <button class="glide__bullet" v-for="(item, index) in articleList" :key="index" type="button" :data-glide-dir="'=' + index"></button>
                    </div>
                </div>
            </div>
            <div class="psearch__last">
                <div class="withstops" v-if="points.length"><em>{{ $t('With stops in') }}</em>
                    <div class="withstops__list">
                        <v-withstops
                            v-for="(item, index) in points"
                            @update_time="updateWithstopsItem"
                            @remove="removeWithstopsItem(item)"
                            :key="index" :data="item"
                        ></v-withstops>
                    </div>
                </div>
                <div class="yourride">
                    <div class="yourride__head">
                        <h3>{{ $t('Your ride') }}</h3>
                        <a v-if="passengers_extra.length > 1" data-fancybox data-src="#select-ride" href="#">{{ $t('Other cars') }}</a>
                    </div>
                    <div class="yourride__selected" :class="{two: passengers.length &gt; 1}">
                        <div class="tickets__footer">
                            <i>
                                <img v-for="(item, index) in passengers" :key="index" :src="'/' + item.car.image" :alt="item.car.title">
                            </i>
                            <div v-for="(item, index) in passengers" :key="index" class="tickets__footer-info">
                                <header>
                                    <h4>{{ item.count > 1 ? item.count + ' ' : '' }}{{ item.car.title }}{{ item.count > 1 ? 's' : '' }}</h4><em>{{ item.car.brand }}</em>
                                </header>
                                <div>
                                    <span>{{ item.car.places_min }} - {{ item.car.places_max }}</span>
                                    <svg class="icon">
                                        <use xlink:href="/img/sprites/sprite.svg#users"></use>
                                    </svg>
                                </div>
                                <div>
                                    <span>{{ item.car.luggage }}</span>
                                    <svg class="icon">
                                        <use xlink:href="/img/sprites/sprite.svg#suitecase"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button>
                                <span>{{ $t('BUY FOR') }} <i :class="currency.toLowerCase() +'_money'"></i>{{ ' ' }} {{ calculatePrice((((this.totalCarPrice + this.withstopsListPrice))).toFixed(2)) }}</span>
                            </button>
                        </div>
                    </div>
                    <div v-for="(item, index) in getPassengersExtraForUpdate" class="yourride__selected extra">
                        <div style="cursor:pointer; color: #03acd1" class="tickets__footer"
                             @click="setCar({car: item.car, count: 1})">
                            <i>
                                <img :src="'/' + item.car.image" :alt="item.car.title">
                            </i>
                            <div class="tickets__footer-info">
                                <div>
                                    <div>
                                        {{ $t('Upgrade to a luxury sedan for') }} <i style="width: 20px" :class="currency.toLowerCase() +'_money'"></i>
                                        {{ calculatePrice(((parseFloat(item.car.price)) + (withstopsListPrice))) }}
                                    </div>
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
                            </i>
                                <span>{{ $t('Support 24/7') }}</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#driver-2"></use>
                                </svg>
                            </i>
                                <span>{{ $t('English-speaking driver') }}</span>
                            </li>
                            <li>
                                <i>
                                    <svg class="icon">
                                        <use xlink:href="/img/sprites/sprite.svg#disabled"></use>
                                    </svg>
                                </i>
                                <span>{{ $t('Prepared for handicapped') }}</span>
                            </li>
                        </ul>
                        <ul>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#car"></use>
                                </svg>
                            </i><span>{{ $t('Clean, comfortable car') }}</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#bottle"></use>
                                </svg>
                            </i><span>{{ $t('Bottled water') }}</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#dist"></use>
                                </svg>
                            </i><span>{{ $t('Door to door service') }}</span></li>
                        </ul>
                        <ul>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#little-kid"></use>
                                </svg>
                            </i><span>{{ $t('Child seats') }}</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#smoking"></use>
                                </svg>
                            </i><span>{{ $t('No-smoking') }}</span></li>
                            <li><i>
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#paw"></use>
                                </svg>
                            </i><span>{{ $t('Pet friendly') }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
        <div class="popup --xl" id="select-ride">
            <form class="popup__wrap">
                <h3>{{ $t('Select your ride') }}</h3>
                <div class="popup-select-rider">
                    <div v-for="(item, index) in passengers_extra" :key="index" @click="setCar(item)">
                        <!--                        <input id="select-auto-1" type="radio" name="select-ride" checked>-->
                        <label for="select-auto-1">
                            <div class="tickets__footer">
                                <i><img :src="'/' + item.car.image" :alt="item.car.title"></i>
                                <div class="tickets__footer-info">
                                    <h4>{{ item.car.title }}</h4><em>{{ item.brand }}</em>
                                    <div><span>{{ item.car.places_min }} - {{ item.car.places_max }}</span>
                                        <svg class="icon">
                                            <use xlink:href="/img/sprites/sprite.svg#users"></use>
                                        </svg>
                                    </div>
                                    <div><span>{{ item.car.luggage }}</span>
                                        <svg class="icon">
                                            <use xlink:href="/img/sprites/sprite.svg#suitecase"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="tickets__footer-price">
                                    <!--                                    <b>{{ currency.toUpperCase() }}{{ calculatePrice((parseFloat(totalCarPrice) + parseFloat(item.car.price)) - (parseFloat(totalCarPrice) + withstopsListPrice)) }}</b>-->
                                    <b><i :class="currency.toLowerCase() +'_money'"></i>{{ calculatePrice(item.car.price + (withstopsListPrice)) }}</b>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <!--                <button class="btn-submit &#45;&#45;simple &#45;&#45;no-opacity &#45;&#45;sm"><span>Save</span></button>-->
            </form>
        </div>
    </section>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";
import initValidation from "../helper/validator";
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
        data: {
            type: Date,
            default: new Date().getHours() + ":" + new Date().getMinutes()
        },
        hours: {
            type: Date,
            default: new Date().getHours()
        },
        minutes: {
            type: Date,
            default: new Date().getMinutes()
        },
        routes: {
            type: Array,
            default: function () {
                return []
            }
        },
        pm: {
            type: Boolean,
            default: true
        },
        errors: [],
        current: false,
        current_route_places: [],
        debug: {
            type: Array,
            default: function () {
                return []
            }
        },
        from: '',
        to: '',
        adults: {
            type: Number,
            default: 1
        },
        childrens: {
            type: Number,
            default: 0
        },
        luggage: {
            type: Number,
            default: 1
        },
        invert: {
            type: Boolean,
            default: false
        },
        invert_route: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            searchInvert: false,
            price: 0,
            route_id: 0,
            places: [],
            withstopsList: [],
            withstopsListPrice: 0,
            passengers: [],
            passengers_extra: [],
            glide: {},
            orderRoute: {
                from: '',
                to: '',
                passengers: null,
                luggage: null,
                childrens: null,
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
    },
    mounted() {
        initValidation(".js-psearch-from");

        let $this = this;
        document.addEventListener("bouncerFormValid", function (el) {
            console.log('bouncerFormValid');
            $this.goToOrder(el)
        });


        console.log('price: ', this.current.price);
        console.log('places: ', this.current.places);
        console.log('current_route_places:', this.current_route_places);
        console.log('debug: ', this.debug);
        console.log('invert: ', this.invert);
        console.log('invert_route: ', this.invert_route);

        console.log('this.$route.params: ', this.$router)
        if (this.current) {
            this.searchInvert = this.invert === 1
            this.route_id = this.current.id;
            this.orderRoute.from = this.searchInvert ? this.current.to_city.name : this.current.from_city.name
            // this.orderRoute.to = this.to
            this.orderRoute.adults = this.adults
            this.orderRoute.childrens = this.childrens
            this.orderRoute.luggage = this.luggage
            this.orderRoute.price_increase = this.current.from_country.price_increase
            this.$store.commit('setCurrencyRate', this.current.from_country.price_increase);
            this.orderRoute.to = this.searchInvert ? this.current.from_city.name : this.current.to_city.name
            this.orderRoute.route_start = this.current.route_start
            this.orderRoute.route_end = this.current.route_end
            // this.price = this.current.price
            this.price = this.current_route_places
            // this.places = this.current.places
            this.places = this.current_route_places
            this.$store.commit('setRoute', this.current);
        }

        this.updatePrice()
        // this.updateCart()


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
        getRouteDate() {
            return Vue.moment(this.data + " " + (parseInt(this.hours)) + ":" + this.minutes + (this.pm ? ' PM' : ' AM'), "DD.MM.YYYY h:m A")
                .format('YYYY.MM.DD HH:mm:ss');
        },
        getOrderTotal() {
            if (parseFloat(this.orderRoute.price_increase) > 0) {
                return (parseFloat(this.orderRoute.price_increase) * ((this.totalCarPrice + this.withstopsListPrice + parseFloat(this.current.price)))).toFixed(2)
            }
            return (((this.totalCarPrice + this.withstopsListPrice + parseFloat(this.current.price)))).toFixed(2)
        },
        getPlaces() {
            console.log('getPlaces');
            axios.post('/api/get_route_places', {route: this.route_id})
                .then(res => {
                    console.log('getPlaces ress;', res);
                    this.places = res.data ?? [];
                })
        },
        getRoute() {
            console.log('getPlaces');
            axios.post('/api/get_route', {route: this.route_id})
                .then(res => {
                    console.log('getPlaces ress;', res);
                    this.places = res.data['current_route_places'] ?? [];
                    this.current = res.data['current_route'] ?? [];
                })
        },
        updateCart(formData) {
            let places = []
            let cars = []

            this.passengers.map(c => {
                cars.push({
                    id: c.car.id,
                    count: c.count,
                    price: c.car.price
                })
            })

            this.points.map(p => {
                places.push(
                    {
                        id: p.id,
                        durations: p.durations + p.extra,
                        price: ((p.price + ((p.extra_durations / 2) * ((p.extra / 30))))).toFixed(2)
                    })
            })

            formData.hours = formData.pm ? (parseInt(formData.hours) + 12) : formData.hours

            console.log(formData.data + " " + formData.hours + ":" + formData.minutes + ":00")

            let route_date = this.getRouteDate()

            let cart = {
                route_id: this.route_id,
                route_date: route_date,
                total: this.getOrderTotal,
                data: this.data,
                hours: this.hours,
                minutes: this.minutes,
                // total: parseFloat(this.current.price) + ((this.totalCarPrice + this.withstopsListPrice) * this.rate).toFixed(2),
                adults: this.adults,
                childrens: this.childrens,
                luggage: this.luggage,
                passengers: this.passengers,
                cars,
                places,
                price: (this.current.price).toFixed(2),
                car_price: (this.totalCarPrice).toFixed(2),
                extraMinutes: this.getExtraMinutes,
                passengersExtra: this.passengers_extra,
                withstopsListPrice: this.withstopsListPrice,
            }
            this.$store.commit('setCart', cart);
        },
        setCar(car) {
            console.log(car);
            this.passengers = [car]
            console.log(this.passengers);
            var f = window.document.getElementsByClassName('fancybox__container')
            if (f && f[0])
                f[0].click()
            return true
        },
        goToOrder(e) {
            e.preventDefault()
            console.log('this.updateCart()');
            console.log(e);

            let formData = {
                minutes: e.target.elements.minutes.value,
                hours: e.target.elements.hours.value,
                pm: e.target.elements.pm.value,
                data: e.target.elements.data.value,
            }
            this.updateCart(formData)
            console.log(e);
            console.log('e.target.elements:', e.target.elements.minutes.value);
            console.log('e.target.elements:', e.target.elements.hours.value);
            console.log('e.target.elements:', e.target.elements.pm.value);
            console.log('e.target.elements:', e.target.elements.data.value);
            let selected = {
                orderRoute: this.orderRoute,
                price: (this.current.price).toFixed(2),
                car_price: (this.totalCarPrice).toFixed(2),
                passengers: this.passengers,
                extraMinutes: this.getExtraMinutes,
                passengersExtra: this.passengers_extra,
                withstopsListPrice: this.withstopsListPrice,
            }
            this.$store.commit('setSelected', selected);
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
        returnPersone(e) {
            console.log('returnPersone: ', e);
            this.passengers = [];
            this.passengers_extra = [];
            let totalPassengers = e.passengers
            let current_passengers = e.passengers
            let inOneCar = this.getCarsOrdered.filter(c => {
                // return current_passengers >= c.places_min && current_passengers <= c.places_max
                return current_passengers <= c.places_max
            })
            if (inOneCar.length > 0) {
                this.passengers.push({car: inOneCar[0], count: 1})

                inOneCar.map(c => {
                    this.passengers_extra.push({car: c, count: 1});
                })
            }
            let inMoreCar = []
            console.log('this.getCarsOrdered.length: ', this.getCarsOrdered.length);
            console.log('-------------------------------------------------------------');
            if (inOneCar.length === 0) {
                for (let i = this.getCarsOrdered.length - 1; i >= 0; i--) {
                    console.log('inMoreCar: ', this.getCarsOrdered[i]['places_max']);
                    console.log('totalPassengers: ', totalPassengers);
                    if (totalPassengers > 0) {
                        console.log('cals CARS', (totalPassengers / parseInt(this.getCarsOrdered[i]['places_max'])));
                        let carsFloat = (totalPassengers / parseInt(this.getCarsOrdered[i]['places_max']));
                        let cars = Math.trunc(totalPassengers / parseInt(this.getCarsOrdered[i]['places_max']))
                        if (cars >= 0) {
                            if (carsFloat - cars > 0.50 || this.getCarsOrdered.length === 1) {
                                cars += 1;
                            }
                            console.log('cars: ', cars);
                            inMoreCar.push({car: this.getCarsOrdered[i], count: cars})
                            totalPassengers -= parseInt(this.getCarsOrdered[i]['places_max']) * (cars === 0 ? 1 : cars)
                        }
                    }
                }
                if (totalPassengers > 0) {
                    for (let i = this.getCarsOrdered.length - 1; i >= 0; i--) {
                        console.log('inMoreCar2: ', this.getCarsOrdered[i]['places_max']);
                        console.log('totalPassengers2: ', totalPassengers);
                        if (totalPassengers > 0) {
                            console.log('cals CARS2', (totalPassengers / parseInt(this.getCarsOrdered[i]['places_max'])));
                            let cars = Math.trunc(totalPassengers / parseInt(this.getCarsOrdered[i]['places_max']))
                            console.log('cars2: ', cars);
                            inMoreCar.push({car: this.getCarsOrdered[i], count: cars})
                            totalPassengers -= parseInt(this.getCarsOrdered[i]['places_max'])
                        }
                    }
                }


            }
            this.passengers.push(...inMoreCar)
        },
        addNewStopItem(item, type) {
            let exists = this.withstopsList.find(val => {
                return val.id === item.id;
            });
            if (!exists) {
                item['extra'] = 0
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
            this.orderRoute.from = item.city;
            this.searchInvert = item.invert;
            // this.orderRoute.from = item.from_city;
            this.$store.commit('clearPoint');
            this.updateError();
        },
        inputFrom() {
            this.updateError();
            this.orderRoute.to = '';
        },
        selectTo(item) {
            this.$store.commit('clearPoint');
            this.$store.commit('setCurrencyRate', this.current.from_country.price_increase);
            this.orderRoute.to = item.to_city;
            this.orderRoute.price_increase = this.current.from_country.price_increase
            this.route_id = item.id
            this.current = item
            // this.getPlaces();
            this.getRoute();
            this.updateError();
        },
        inputTo() {
            this.updateError();
        },
        change() {
            console.log('change');
            console.log(this.orderRoute);
            let from = this.orderRoute.from;
            let to = this.orderRoute.to;
            this.orderRoute.from = to;
            this.orderRoute.to = from;
            this.searchInvert = !this.searchInvert
            this.updateError();
        },

        toggle() {
            setTimeout(() => {
                this.openedFrom = false;
                this.openedTo = false;
            }, 300);
        },
        updatePrice() {
            this.withstopsListPrice = 0;
            this.points.forEach(item => {
                this.withstopsListPrice += (item.price + ((item.extra / 30) * (item.extra_durations / 2)))
            });
        },
        calculatePrice(price) {
            return ((parseFloat(price) + parseFloat(this.current.price)) * parseFloat(this.total_rate)).toFixed(2)
        }
    },
    computed: {
        ...mapState({
            cart: store => store.cart,
            count: store => store.count,
            route: store => store.route,
            points: store => store.points,
            rate: store => store.rate,
            currency: store => store.currency,
            country_rate: store => store.country_rate,
            total_rate: store => (store.total_rate).toFixed(2),
        }),
        getPassengersExtraForUpdate() {
            if (this.passengers.length === 1) {

                console.log(this.passengers[0]);
                console.log(this.passengers_extra);

                let current_car_id = this.passengers[0].car.id

                let current_auto = this.passengers_extra.findIndex(function (item) {
                    return item.car.id === current_car_id;
                });
                console.log('current_auto: ', current_auto);
                console.log('this.passengers_extra.length: ', this.passengers_extra.length);

                if (current_auto + 1 >= this.passengers_extra.length) {
                    return []
                } else {
                    return [this.passengers_extra[current_auto + 1]]
                }

            }
            return []
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
        getExtraMinutes() {
            let extraMinutes = 0;
            this.points.forEach(item => {
                extraMinutes += parseInt(item.durations) + parseInt(item.extra);
            });
            return extraMinutes;
        },
        totalCarPrice() {
            let totalPrice = 0;
            this.passengers.forEach(p => {
                totalPrice += parseFloat(p.car.price)
            })
            return totalPrice;
        },
        getCurrentRoutePlaces() {
            return this.places
        },
        ampm() {
            return this.pm ? "PM" : "AM";
        },

        filteredRoutes() {

            if (true) {
                console.log('this.parsedRoutes: ', this.parsedRoutes);

                const allRoutesResult = []

                this.routes.forEach(p => {
                    allRoutesResult.push({city: p.from_city, country: p.from_country, invert: false})
                    allRoutesResult.push({city: p.to_city, country: p.to_country, invert: true})
                })


                // const fromRoutesResult = this.parsedRoutes.filter(r => {
                //     return this.selectedFrom.length > 0 ? r.to_city.toLowerCase().indexOf(this.selectedFrom.toLowerCase()) >= 0 : true;
                // }).filter(r => {
                //     return this.selectedTo.length > 0 ? r.from_city.toLowerCase().indexOf(this.selectedTo.toLowerCase()) >= 0 : true;
                // }).map(i => {
                //     return {from_city: i.from_city, from_country: i.from_country, to_city: i.to_city, to_country: i.to_country}
                // })

                const fromRoutesResult = allRoutesResult.filter(r => {
                    return this.orderRoute.from.length > 0 ? r.city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
                })

                const fromCitiesList = [];

                fromRoutesResult.forEach(i => {
                    if (fromCitiesList.findIndex((element) => element.city === i.city) < 0) {
                        fromCitiesList.push(i)
                    }
                })
                return fromCitiesList

            }
            //
            // if (this.invert) {
            //     console.log('this.parsedRoutes: ', this.routes);
            //     const fromRoutesResult = this.routes.filter(r => {
            //         return this.orderRoute.from.length > 0 ? r.to_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
            //     }).filter(r => {
            //         return this.orderRoute.to.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.to.toLowerCase()) >= 0 : true;
            //     }).map(i => {
            //         return {from_city: i.from_city, from_country: i.from_country, to_city: i.to_city, to_country: i.to_country}
            //     })
            //     const fromCitiesList = [];
            //
            //     fromRoutesResult.forEach(i => {
            //         if (fromCitiesList.findIndex((element) => element.to_city === i.to_city) < 0) {
            //             fromCitiesList.push(i)
            //         }
            //     })
            //     return fromCitiesList
            //
            //     // return this.parsedRoutes.filter(r => {
            //     //     return this.selectedFrom.length > 0 ? r.to_city.toLowerCase().indexOf(this.selectedFrom.toLowerCase()) >= 0 : true;
            //     // }).filter(r => {
            //     //     return this.selectedTo.length > 0 ? r.from_city.toLowerCase().indexOf(this.selectedTo.toLowerCase()) >= 0 : true;
            //     // })
            // }
            //
            // console.log('this.parsedRoutes: ', this.routes);
            // const fromRoutesResult = this.routes.filter(r => {
            //     return this.orderRoute.from.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
            // }).filter(r => {
            //     return this.orderRoute.to.length > 0 ? r.to_city.toLowerCase().indexOf(this.orderRoute.to.toLowerCase()) >= 0 : true;
            // }).map(i => {
            //     return {from_city: i.from_city, from_country: i.from_country, to_city: i.to_city, to_country: i.to_country}
            // })
            // const fromCitiesList = [];
            //
            // fromRoutesResult.forEach(i => {
            //     if (fromCitiesList.findIndex((element) => element.from_city === i.from_city) < 0) {
            //         fromCitiesList.push(i)
            //     }
            // })
            // return fromCitiesList
        },
        filteredRoutesTo() {

            if (this.searchInvert) {

                return this.routes.filter(r => {
                    return this.orderRoute.from.length > 0 ? r.to_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
                }).filter(r => {
                    return this.orderRoute.to.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.to.toLowerCase()) >= 0 : true;
                })

                // const toRoutesResult = this.parsedRoutes.filter(r => {
                //     return this.selectedFrom.length > 0 ? r.to_city.toLowerCase().indexOf(this.selectedFrom.toLowerCase()) >= 0 : true;
                // }).filter(r => {
                //     return this.selectedTo.length > 0 ? r.from_city.toLowerCase().indexOf(this.selectedTo.toLowerCase()) >= 0 : true;
                // }).map(i => {
                //     return {from_city: i.from_city, from_country: i.from_country, to_city: i.to_city, to_country: i.to_country}
                // })
                // const toCitiesList = [];
                //
                // toRoutesResult.forEach(i=>{
                //     if (toCitiesList.findIndex( (element) => element.to_city === i.to_city) < 0){
                //         toCitiesList.push(i)
                //     }
                // })
                // return toCitiesList
            }

            return this.routes.filter(r => {
                return this.orderRoute.from.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
            }).filter(r => {
                return this.orderRoute.to.length > 0 ? r.to_city.toLowerCase().indexOf(this.orderRoute.to.toLowerCase()) >= 0 : true;
            })
        }


        // filteredRoutes() {
        //
        //     if (this.invert === 1){
        //         return this.routes.filter(r => {
        //             return this.orderRoute.from.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
        //         }).filter(r => {
        //             return this.orderRoute.to.length > 0 ? r.to_city.toLowerCase().indexOf(this.orderRoute.to.toLowerCase()) >= 0 : true;
        //         })
        //     }
        //
        //     const fromRoutesResult =  this.routes.filter(r => {
        //         return this.orderRoute.from.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
        //     }).map(i => {
        //         return {from_city: i.from_city, from_country: i.from_country}
        //     })
        //     const fromCitiesList = [];
        //
        //     fromRoutesResult.forEach(i=>{
        //         if (fromCitiesList.findIndex( (element) => element.from_city === i.from_city) < 0){
        //             fromCitiesList.push(i)
        //         }
        //     })
        //     return fromCitiesList
        // },
        //
        // filteredRoutesTo() {
        //
        //     if (this.invert === 1){
        //         const fromRoutesResult =  this.routes.filter(r => {
        //             return this.orderRoute.from.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
        //         }).map(i => {
        //             return {from_city: i.from_city, from_country: i.from_country, to_city: i.to_city, to_country: i.to_country}
        //         })
        //         const fromCitiesList = [];
        //
        //         fromRoutesResult.forEach(i=>{
        //             if (fromCitiesList.findIndex( (element) => element.from_city === i.from_city) < 0){
        //                 fromCitiesList.push(i)
        //             }
        //         })
        //         return fromCitiesList
        //     }
        //
        //     return this.routes.filter(r => {
        //         return this.orderRoute.from.length > 0 ? r.from_city.toLowerCase().indexOf(this.orderRoute.from.toLowerCase()) >= 0 : true;
        //     }).filter(r => {
        //         return this.orderRoute.to.length > 0 ? r.to_city.toLowerCase().indexOf(this.orderRoute.to.toLowerCase()) >= 0 : true;
        //     })
        // }
    },
    watch: {
        points() {
            this.updatePrice()
        }
    }
});
</script>
