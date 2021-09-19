<template>
    <div class="calc" id="calculator">
        <form class="js-calculator" data-submit="calculatorSubmit">
            <v-select></v-select>
            <div class="date-time">
                <v-custom-calendar></v-custom-calendar>
                <v-time></v-time>
            </div>
            <v-humans></v-humans>
            <div class="calc__items">
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
            <div class="calc__form">
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

export default Vue.component("v-calculator", {
    comments: {
        Extrastops,
        Extrasteps,
        Choosecar,
        Requirements
    },
    data() {
        return {
            extrastops: false,
            choosecar: false,
            requirements: false
        };
    },
    props: {
        error: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        ampm() {
            return this.pm ? "PM" : "AM";
        }
    },
    methods: {
        toggle(item) {
            this[item] = !this[item];
        }
    },
    mounted() {
        initValidation(".js-calculator");
    }
});

</script>
