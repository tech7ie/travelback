<template>
    <div class="extrastops" v-click-outside="close" :class="{ opened }" style="z-index: 9; position:relative;">
        <div class="extrastops__item">
            <input type="hidden" :value="selected" :name="'extrastops' + index">
            <span>Stops {{ index + 1 }}</span>
            <div class="extrastops__select">
                <div class="extrastops__select-head" @click="toggle">
                    <span>{{ selected }} min</span>
                    <svg class="icon arrow-down">
                        <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
                    </svg>
                </div>
                <ul v-if="opened">
                    <li v-for="(item, index) in list" :key="index" @click="select(item)">
                        <span>{{ item }} min</span>
                    </li>
                </ul>
            </div>
        </div>
        <button type="button" @click="remove">
            <svg class="icon close-small">
                <use xlink:href="img/sprites/sprite.svg#close-small"></use>
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
            opened: true,
            list: [60, 80, 100, 120, 140],
            selected: 0
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
