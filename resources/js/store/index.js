import Vue from "vue";
import VuexPersistence from 'vuex-persist'

const vuexLocal = new VuexPersistence({
    storage: window.localStorage
})


let cart = window.localStorage.getItem('cart');
let points = window.localStorage.getItem('points');


const store = {
    state: {
        cart: cart ? JSON.parse(cart) : [],
        route: null,
        selected: null,
        points: points ? JSON.parse(points) : [],
        rate: 1,
        total_rate: 1,
        country_rate: 0,
        count: 0,
        currency: 'eur',
        currency_rate: 1,
        currency_rates: null,
    },
    mutations: {
        clearPoint(state) {
            //console.log('clearPoint');
            Vue.set(state, 'points', [])
        },
        setRate(state, rate) {
            state.rate = rate.rate ?? 1
            state.total_rate = (state.currency_rate) > 0 ? ((state.rate - 1) + state.currency_rate) : state.rate
        },
        setCurrencyRate(state, currency_rate) {
            //console.log('currency_rates: ', currency_rate);
            state.currency_rate = currency_rate ?? 1
            state.total_rate = (state.currency_rate) > 0 ? ((state.rate - 1) + state.currency_rate) : state.rate
        },
        setCart(state, cart) {
            //console.log('setCart');
            state.cart = cart
        },
        setCurrency(state, currency) {
            state.currency = currency
        },
        setCurrencyRates(state, currency_rates) {
            state.currency_rates = currency_rates
        },
        setRoute(state, item) {
            state.route = item
            state.count++;
        },
        setSelected(state, selected) {
            state.selected = selected
        },
        addPoint(state, item) {
            Vue.set(state, 'points', [...state.points, item])
        },
        saveCart(state) {
            //console.log('saveCart');
        },
        removePoint(state, item) {
            state.points.splice(state.points.indexOf(item), 1);
        },
        clearOrder(state, item) {
            Vue.set(state, 'cart', [])
            Vue.set(state, 'route', [])
            Vue.set(state, 'points', [])
            state.selected = {
                orderRoute: {
                    from: '',
                    to: '',
                    passengers: [],
                    luggage: null,
                    childrens: null,
                    route_start: null,
                    route_end: null,
                }
            }

        },
        updatePointTime(state, item) {
            let place = state.points[state.points.indexOf(item.data)]
            Vue.set(place, 'extra', item.extra)
            Vue.set(state, 'points', [...state.points])
        },
        choseCar(state, item) {
            //console.log('choseCar', item);
            Vue.set(state.selected, 'passengers', [item])
            Vue.set(state.selected, 'car_price', item.car.price)
        }
    },
    getters: {
    },
    plugins: [vuexLocal.plugin]
}

export default store
