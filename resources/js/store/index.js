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
        count: 0
    },
    mutations: {
        setRoute(state, item) {
            state.route = item
            state.count++;
        },
        setSelected(state, selected) {
            state.selected = selected
        },
        addPoint(state, item) {
            // Vue.set(this.$store.state.nav, 'type', 'wide');
            state.points = [...state.points, item]
            // state.points.push(item)
        },
        saveCart(state) {
            console.log('saveCart');
        },
        removePoint(state, item) {
            state.points.splice(state.points.indexOf(item), 1);
        },
        updatePointTime(state, item) {
            // console.log(state.points[state.points.indexOf(item.data)]);
            console.log('1 place.extra: ',item.extra);
            // console.log(state.points[state.points.indexOf(item.data)].extra);

            // state.points[state.points.indexOf(item.data)].extra = item.extra;

            let place = state.points[state.points.indexOf(item.data)]
            // state.points[state.points.indexOf(item.data)] = Object.assign({}, state.points[state.points.indexOf(item.data)], { extra: item.extra})
            Vue.set(place, 'extra', item.extra)
            // Vue.set(state.points[state.points.indexOf(item.data)], {...state.points[state.points.indexOf(item.data)], extra: item.extra})
            console.log('2 place.extra: ',place.extra);
        }
    },
    plugins: [vuexLocal.plugin]
}

export default store
