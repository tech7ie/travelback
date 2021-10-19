<template>
    <div>
        <v-extrastops-item @remove="removeItem" v-for="(item, index) in list" :key="index" :item="item" :index="index"></v-extrastops-item>
        <div class="extrastops disabled">
            <div class="extrastops__item">
                <span>Stops {{ list.length + 1 }}</span>
                <div class="extrastops__select">
                    <div class="extrastops__select-head" @click="toggle">
                        <span>0 min</span>
                        <svg class="icon arrow-down">
                            <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
                        </svg>
                    </div>
                </div>
            </div>
            <button type="button" @click="addItem">
                <svg class="icon plus">
                    <use xlink:href="img/sprites/sprite.svg#plus"></use>
                </svg>
            </button>
        </div>
    </div>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";

export default Vue.component("v-extrastops", {
    data() {
        return {
            opened: true,
            list: [60, 80, 100, 120, 140],
            selected: 0
        };
    },
    props: {
        disabled: {
            type: Boolean,
            default: false
        },
        list: {
            type: Array,
            default: []
        }
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
        addItem() {
            this.list.push({});
        },
        removeItem(index) {
            //console.log(index)
            this.list.splice(this.list.indexOf(this.list[index]), 1);
        }
    },
    directives: {
        ClickOutside
    }
});
</script>
