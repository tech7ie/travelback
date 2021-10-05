<template>
    <div class="calc" id="calculator">
        <form class="js-calculator" data-submit="calculatorSubmit">
            <div class="custom-select">
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
                            @keyup="openedTo = true"
                            @blur="toggle"
                        />
                    </div>
                    <div class="custom-select__options" :class="{ '--opened': openedTo }">
                        <div class="custom-select__option" @click="selectTo(item)" v-for="(item, index) in filteredRoutes" :key="index">
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
            <v-humans></v-humans>
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
            <div class="label --white">* required for departures within 48 hours</div>
            <button class="btn-submit"><span>Search</span></button>
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
            parsedRoutes: [],
            extrastops: false,
            choosecar: false,
            requirements: false,
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
        error: {
            type: Boolean,
            default: false
        },
        routes: {
            type: Array,
            default: function () {
                return []
            }
        },
        short: false
    },
    computed: {
        ampm() {
            return this.pm ? "PM" : "AM";
        },
        filteredRoutes(){
            return this.parsedRoutes.filter(r => {
                return this.selectedFrom.length >0 ? r.from_city.toLowerCase().indexOf(this.selectedFrom.toLowerCase()) >= 0 : true;
            }).filter(r => {
                return this.selectedTo.length >0 ? r.to_city.toLowerCase().indexOf(this.selectedTo.toLowerCase()) >= 0 : true;
            })
        }
    },
    methods: {
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
        }
    },
    mounted() {
        initValidation(".js-calculator");
        this.parsedRoutes = JSON.parse(this.routes)
    },
    directives: {
        ClickOutside
    }
});

</script>
