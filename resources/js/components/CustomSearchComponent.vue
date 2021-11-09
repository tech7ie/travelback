<template>
    <section class="psearch" id="psearch">
        <form class="container psearch__wrap js-psearch-from">
            <input name="route" type="text" :value="parseInt(route_id)" hidden>
            <div class="psearch__form">
                <div class="psearch__head">
                    <h2>{{ orderRoute.from }}
                        <svg class="icon">
                            <use xlink:href="/img/sprites/sprite.svg#arrow-long"></use>
                        </svg>
                        {{ orderRoute.to }}
                    </h2>
                    <em>Estimated arrival {{ orderRoute.route_end | moment("add", getExtraMinutes + " m", "h:mm:ss A") }}</em>
                </div>
                {{ getRouteDate() }}
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
                        <v-custom-calendar :d="data"></v-custom-calendar>
                        <v-time :h="hours" :m="minutes"></v-time>
                    </div>
                    <v-humans :data="{adults,childrens,luggage}" @return="returnPersone"></v-humans>
                </div>
            </div>
            <div class="psearch__other">
                <h3>Visit along the way</h3>
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
                <div class="withstops" v-if="points.length"><em>With stops in</em>
                    <div class="withstops__list">
                        <v-withstops v-for="(item, index) in points" @update_time="updateWithstopsItem" @remove="removeWithstopsItem(item)" :key="index" :data="item"></v-withstops>
                    </div>
                </div>
                <div class="yourride">
                    <div class="yourride__head">
                        <h3>Your ride</h3>
                        <a v-if="passengers_extra.length > 1" data-fancybox data-src="#select-ride" href="#">Other cars</a>
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
                                <span>BUY FOR {{ currency.toUpperCase() }}{{ ' ' }} {{ calculatePrice((((this.totalCarPrice + this.withstopsListPrice + parseFloat(this.current.price)))).toFixed(2)) }}</span>
                            </button>
                        </div>
                    </div>
                    <div class="yourride__selected extra" v-if="passengers_extra.length > 1">
                        <div style="cursor:pointer; color: #03acd1" class="tickets__footer"
                             @click="setCar({car: passengers_extra[1].car, count: 1})">
                            <i>
                                <img :src="'/' + passengers_extra[1].car.image" :alt="passengers_extra[1].car.title">
                            </i>
                            <div class="tickets__footer-info">
                                <div>
                                    Upgrade to a luxury sedan for {{ currency.toUpperCase() }}
                                    {{ calculatePrice(((totalCarPrice + parseFloat(passengers_extra[1].car.price)) - (totalCarPrice + withstopsListPrice))) }}
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
                    <div v-for="(item, index) in passengers_extra" :key="index" @click="setCar(item)">
                        <!--                        <input id="select-auto-1" type="radio" name="select-ride" checked>-->
                        <label for="select-auto-1">
                            <div class="tickets__footer">
                                <i><img :src="'/' + item.car.image" :alt="item.car.title"></i>
                                <div class="tickets__footer-info">
                                    <h4>{{ item.car.title }}</h4><em>{{ item.brand }}</em>
                                    <div><span>{{ item.car.places_min }} - {{ item.car.places_max }}</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#users"></use>
                                        </svg>
                                    </div>
                                    <div><span>{{ item.car.luggage }}</span>
                                        <svg class="icon">
                                            <use xlink:href="img/sprites/sprite.svg#suitecase"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="tickets__footer-price">
                                    <!--                                    <b>{{ currency.toUpperCase() }}{{ calculatePrice((parseFloat(totalCarPrice) + parseFloat(item.car.price)) - (parseFloat(totalCarPrice) + withstopsListPrice)) }}</b>-->
                                    <b>{{ currency.toUpperCase() }}{{ calculatePrice(item.car.price) }}</b>
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
    },
    data() {
        return {
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

        if (this.current) {
            this.route_id = this.current.id;
            this.orderRoute.from = this.current.from_city.name
            // this.orderRoute.to = this.to
            this.orderRoute.adults = this.adults
            this.orderRoute.childrens = this.childrens
            this.orderRoute.luggage = this.luggage
            this.orderRoute.price_increase = this.current.from_country.price_increase
            this.$store.commit('setCurrencyRate', this.current.from_country.price_increase);
            this.orderRoute.to = this.current.to_city.name
            this.orderRoute.route_start = this.current.route_start
            this.orderRoute.route_end = this.current.route_end
            this.price = this.current.price
            this.places = this.current.places
            this.$store.commit('setRoute', this.current);
        }

        this.updatePrice()
        this.updateCart()


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
            console.log('this.pm', this.pm);
            return Vue.moment(this.data + " " + (parseInt(this.hours) + (this.pm ? 12 : 0)) + ":" + this.minutes + ":00", "DD.MM.YYYY h:m:ss ")
                .format('YYYY.MM.DD hh:mm:ss');
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
        updateCart(formData) {
            let places = []
            let cars = []

            // console.log('date: ', (this.data + " " + this.hours + ":" + this.minutes));


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

            // console.log(formData.data + " " + formData.hours + ":" + formData.minutes + ":00")

            let route_date = Vue.moment(formData.data + " " + formData.hours + ":" + formData.minutes + ":00", "DD.MM.YYYY HH:mm:ss")
                .format('YYYY.MM.DD HH:mm:ss');

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
            if (f)
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
            console.log('returnPersone: ', e);
            this.passengers = [];
            this.passengers_extra = [];
            let totalPassengers = e.passengers
            let current_passengers = e.passengers
            let inOneCar = this.getCarsOrdered().filter(c => {
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
            console.log('this.getCarsOrdered().length: ', this.getCarsOrdered().length);
            console.log('-------------------------------------------------------------');
            if (inOneCar.length === 0) {
                for (let i = this.getCarsOrdered().length - 1; i >= 0; i--) {
                    console.log('inMoreCar: ', this.getCarsOrdered()[i]['places_max']);
                    console.log('totalPassengers: ', totalPassengers);
                    if (totalPassengers > 0) {
                        console.log('cals CARS', (totalPassengers / parseInt(this.getCarsOrdered()[i]['places_max'])));
                        let carsFloat = (totalPassengers / parseInt(this.getCarsOrdered()[i]['places_max']));
                        let cars = Math.trunc(totalPassengers / parseInt(this.getCarsOrdered()[i]['places_max']))
                        if (cars >= 0) {
                            if (carsFloat - cars > 0.50 || this.getCarsOrdered().length === 1) {
                                cars += 1;
                            }
                            console.log('cars: ', cars);
                            inMoreCar.push({car: this.getCarsOrdered()[i], count: cars})
                            totalPassengers -= parseInt(this.getCarsOrdered()[i]['places_max']) * (cars === 0 ? 1 : cars)
                        }
                    }
                }
                if (totalPassengers > 0) {
                    for (let i = this.getCarsOrdered().length - 1; i >= 0; i--) {
                        console.log('inMoreCar2: ', this.getCarsOrdered()[i]['places_max']);
                        console.log('totalPassengers2: ', totalPassengers);
                        if (totalPassengers > 0) {
                            console.log('cals CARS2', (totalPassengers / parseInt(this.getCarsOrdered()[i]['places_max'])));
                            let cars = Math.trunc(totalPassengers / parseInt(this.getCarsOrdered()[i]['places_max']))
                            console.log('cars2: ', cars);
                            inMoreCar.push({car: this.getCarsOrdered()[i], count: cars})
                            totalPassengers -= parseInt(this.getCarsOrdered()[i]['places_max'])
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
            this.orderRoute.from = item.from_city;
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
            this.getPlaces();
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
            this.withstopsListPrice = 0;
            this.points.forEach(item => {
                this.withstopsListPrice += (item.price + ((item.extra / 30) * (item.extra_durations / 2)))
            });
        },
        calculatePrice(price) {
            console.log('calculatePrice');
            console.log(price);
            console.log(this.total_rate);
            return (parseFloat(price) * parseFloat(this.total_rate)).toFixed(2)
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
