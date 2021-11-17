<template>
    <div class="choosecar" v-click-outside="close">
        <div class="choosecar__head" @click="toggle">
            <div class="choosecar__item">
                <i>
                    <img :src="selected.img" alt="sedan">
                </i>
                <span>{{ selected.name }}</span>
                <svg class="icon arrow-down">
                    <use xlink:href="/img/sprites/sprite.svg#arrow-down"></use>
                </svg>
            </div>
        </div>

        <ul v-show="opened">
            <li v-for="(item, index) in list" :key="index" @click="select(item)">
                <div class="choosecar__item">
                    <i>
                        <img :src="item.img" :alt="item.name">
                    </i>
                    <span>{{ item.name }}</span>
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";

export default Vue.component("v-choosecar", {
    data() {
        return {
            list: [
                {
                    img: "/img/cars/sedan.png",
                    name: "Sedan - Skoda Superb"
                },
                {
                    img: "/img/cars/sportage.png",
                    name: "SUV - KIA Sportage"
                },
                {
                    img: "/img/cars/sharan.png",
                    name: "MPV - Volkswagen Sharan"
                },
                {
                    img: "/img/cars/vito.jpg",
                    name: "Van - Mercedes Vito"
                },
                {
                    img: "/img/cars/sprinter.png",
                    name: "Mercedes Sprinter"
                },
                {
                    img: "/img/cars/minibus.png",
                    name: "Minibus - Sprinter Tourer"
                },
                {
                    img: "/img/cars/bus.png",
                    name: "Bus - SETRA"
                }
            ],
            selected: {},
            opened: false
        };
    },
    created() {
        this.selected = this.list[0]
    },
    methods: {
        select(item) {
            this.selected = item;
            this.opened =  false;
        },
        toggle() {
            this.opened = !this.opened;
        },
        close() {
            this.opened = false;
        }
    },
    directives: {
        ClickOutside
    }
});
</script>
