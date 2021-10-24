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
        count: 0,
        currency: 'eur',
        currency_rates: null,
    },
    mutations: {
        clearPoint(state) {
            console.log('clearPoint');
            Vue.set(state, 'points', [])
        },
        setRate(state, rate) {
            state.rate = rate.rate ?? 1
        },
        setCart(state, cart) {
            console.log('setCart');
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
            console.log('saveCart');
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
                    passengers: null,
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
        }
    },
    getters: {

    },
    plugins: [vuexLocal.plugin]
}

export default store
