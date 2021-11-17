<template>
    <div class="calc" id="calculator">
        <form @submit.prevent="submitForm" class="js-calculator" data-submit="calculatorSubmit" :action="searchActionsUrl">
            <div class="custom-select">
                <input type="number" :value="filteredRoutesTo.length > 0 ? filteredRoutesTo[0].id : 0" name="route" hidden>
                <div class="custom-select__item" :class="{'--active': openedFrom }">
                    <div class="custom-select__head" data-input-parent :class="{error: errorFrom}">
                        <input
                            name="from"
                            placeholder="From"
                            @input="inputFrom"
                            required="required"
                            type="search"
                            v-model="selectedFrom"
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
                            v-model="selectedTo"
                            autocomplete="off"
                            @focus="openedTo = true"
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
            <div class="date-time">
                <v-custom-calendar></v-custom-calendar>
                <v-time></v-time>
            </div>
            <v-humans :data="{adults,childrens,luggage}"></v-humans>
            <div v-if="!this.short" class="calc__items">
                <div class="calc__item"><b @click="toggle('extrastops')">+ Extra stops</b>
                    <v-extrastops v-if="extrastops"></v-extrastops>
                </div>
                <div class="calc__item"><b @click="toggle('choosecar')">+ Choose car</b>
                    <v-choosecar v-if="choosecar"></v-choosecar>
                </div>
                <div class="calc__item"><b @click="toggle('requirements')">+ Requirements</b>
                    <v-requirements v-if="requirements"></v-requirements>
                </div>
            </div>
            <div v-if="!this.short" class="calc__form">
                <input class="half" name="first-name" placeholder="First name:" required>
                <input class="half" name="last-name" placeholder="Last name:" required>
                <input type="email" name="email" placeholder="Email:" required>
            </div>
            <template v-if="filteredRoutes.length === 0 && mode === 'home'">
                <div class="form-vue__footer --line">
                    <span>Can't find your destination?</span>
                    <a :href="getRequestUrl">Request a custom route</a>
                </div>
            </template>
            <template v-else>
                <div  v-if="mode === 'request' || mode === 'home'" class="label --white">* required for departures within 48 hours</div>
            </template>
            <button class="btn-submit">
                <span v-if="mode === 'home'">Search</span>
                <span v-else>Request</span>
            </button>
        </form>
    </div>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import initValidation from "./helper/validator";
import Extrastops from "./ExtrastopsComponent";
import Extrasteps from "./ExtrastepsComponent";
import Choosecar from "./ChoosecarComponent";
import Requirements from "./RequirementsComponent";
import ClickOutside from "vue-click-outside";

export default Vue.component("v-calculator", {
    comments: {
        Extrastops,
        Extrasteps,
        Choosecar,
        Requirements
    },
    data() {
        return {
            searchActionsUrl: '',
            parsedRoutes: [],
            extrastops: false,
            choosecar: false,
            requirements: false,
            route_id: null,
            filter: {
                from: '',
                to: ''
            },
            openedFrom: false,
            openedTo: false,
            selectedFrom: "",
            errorFrom: false,
            selectedTo: "",
            errorTo: false,
            firstStart: false,
        };
    },
    props: {
        mode: {
            type: String,
            default: "home"
        },
        error: {
            type: Boolean,
            default: false
        },
        routes: {
            type: String,
            default: "[]"
        },
        short: false,
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
        request: {
            type: Array,
            default: function () {
                return [{
                    from: '',
                    to: ''
                }]
            }
        }
    },
    computed: {
        getRequestUrl() {
            return '/' + window.App.language + '/request?' + 'from=' + this.selectedFrom + '&to=' + this.selectedTo
        },
        ampm() {
            return this.pm ? "PM" : "AM";
        },
        filteredRoutes() {
            return this.parsedRoutes.filter(r => {
                return this.selectedFrom.length > 0 ? r.from_city.toLowerCase().indexOf(this.selectedFrom.toLowerCase()) >= 0 : true;
            }).filter(r => {
                return this.selectedTo.length > 0 ? r.to_city.toLowerCase().indexOf(this.selectedTo.toLowerCase()) >= 0 : true;
            })
        },
        filteredRoutesTo() {
            return this.parsedRoutes.filter(r => {
                return this.selectedFrom.length > 0 ? r.from_city.toLowerCase().indexOf(this.selectedFrom.toLowerCase()) >= 0 : true;
            }).filter(r => {
                return this.selectedTo.length > 0 ? r.to_city.toLowerCase().indexOf(this.selectedTo.toLowerCase()) >= 0 : true;
            })
        }
    },
    methods: {
        submitForm(e) {
            e.preventDefault()

            console.log('this.mode: ', this.mode);

            const formData = new FormData(e.target);
            const formProps = Object.fromEntries(formData);

            this.$store.commit('setCart', formProps);

            console.log('formProps: ', formProps);

            this.$store.commit('clearPoint');
            return false;
        },
        toggle(item) {
            this[item] = !this[item];
            setTimeout(() => {
                this.openedFrom = false;
                this.openedTo = false;
            }, 300);
        },
        updateError() {
            // this.errorFrom = this.selectedFrom.length <= 2;
            // this.errorTo = this.selectedTo.length <= 2;
        },
        selectFrom(item) {
            // this.openedFrom = false;
            this.selectedFrom = item.from_city;
            this.updateError();
        },
        inputFrom() {
            this.updateError();
        },
        selectTo(item) {
            // this.openedTo = false;
            this.selectedTo = item.to_city;
            this.route_id = item.route_id;
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
            this.$store.commit('clearPoint');
            this.updateError();
        },
        search() {

            this.$store.commit('setCart', cart);
        }
    },
    mounted() {


        console.log('this.mode: mounted:  ', this.mode);

        initValidation(".js-calculator");

        let $this = this;

        document.addEventListener("bouncerFormValid", function (el) {

            // console.log('this.mode', this.mode);
            if ($this.mode === 'home'){
                $this.submitForm(el)
                try {
                    var form = event.target;
                    form.submit(this)
                    console.log('error');
                } catch (e) {
                    console.log(e);
                    console.log("Form Submit Error!");
                }
            }
        });
        this.parsedRoutes = JSON.parse(this.routes)
        this.searchActionsUrl = '/' + (window.App.language ?? 'en') + '/search';
        this.selectedFrom = this.request.from ?? ''
        this.selectedTo = this.request.to ?? ''
        this.selectedTo = this.request.to ?? ''
        this.selectedTo = this.request.to ?? ''
    },
    directives: {
        ClickOutside
    }
});

</script>
