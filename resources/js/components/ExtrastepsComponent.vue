<template>
    <div class="extrastops" v-click-outside="close" :class="{ opened }" style="z-index: 9; position:relative;">
        <div class="extrastops__item">
            <input type="hidden" :value="selected" :name="'extrastops' + index">
            <span>
                <input type="text" :value="step" :placeholder="'Stops' +  (index + 1)"
                       style="{
                width: 100%;
                background-color: rgb(255, 255, 255);
                margin-bottom: 0;
                outline: 0;
                }">
            </span>

            <div class="extrastops__select">
                <div class="extrastops__select-head" @click="toggle">
                    <span>{{ selected }} min</span>
                    <svg class="icon arrow-down">
                        <use xlink:href="/img/sprites/sprite.svg#arrow-down"></use>
                    </svg>
                </div>
                <div class="extrastops__list" v-if="opened">
                    <ul>
                        <li v-for="(item, index) in list" :key="index" @click="select(item)">
                            <span>{{ item }} min</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <button type="button" class="remove" @click="remove">
            <svg class="icon close-small">
                <use xlink:href="/img/sprites/sprite.svg#close-small"></use>
            </svg>
        </button>
    </div>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";

export default Vue.component("v-extrastops-item", {
    data() {
        return {
            opened: false,
            step: '',
            list: [
                60,
                80,
                100,
                120,
                140,
                160,
                180,
                200,
                220,
                240,
                260,
                280,
                300,
                320,
                340,
                360,
                380,
                400,
                420,
                440,
                460,
                480,
                500,
                520,
                540,
                560,
                580,
                600,
                620,
                640,
                660,
                680,
                700,
                720,
                740,
                760,
                780,
                800,
                820,
                840,
                860,
                880,
                900,
                920,
                940,
                960,
                980,
                1000,
                1020,
                1040,
                1060,
                1080,
                1100,
                1120,
                1140,
                1160,
                1180,
                1200,
                1220,
                1240,
                1260,
                1280,
                1300,
                1320,
                1340,
                1360,
                1380,
                1400,
                1420,
                1440
            ],
            selected: 60
        };
    },
    props: {
        index: Number,
        item: Object
    },
    methods: {
        toggle() {
            this.opened = !this.opened;
        },
        close() {
            this.opened = false;
        },
        select(value) {
            this.selected = value;
            this.opened = false;
            this.$emit("return", value);
        },
        remove() {
            this.$emit("remove", this.index)
        }
    },
    directives: {
        ClickOutside
    }
});
</script>
