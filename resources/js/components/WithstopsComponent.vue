<template>
    <div class="withstops__list-item">
        <i>
            <img :src="'/' + data.image" alt="IMG"/>
        </i>
        <div>
            <b>{{ data.title }}</b>
            <span>{{ data.date }}</span>
        </div>
        <div class="incdec --max">
            <div class="incdec__plus" @click="minus">
                <svg class="icon minus">
                    <use xlink:href="/img/sprites/sprite.svg#minus"></use>
                </svg>
            </div>
            <div class="incdec__input"><span>{{ selected }} min</span></div>
            <input type="hidden" :name="'withstops-' + data.id" :value="selected">
            <div class="incdec__minus" @click="plus">
                <svg class="icon plus">
                    <use xlink:href="/img/sprites/sprite.svg#plus"></use>
                </svg>
            </div>
        </div>
        <b>€ {{ data.price }}</b>
        <button type="button" @click="remove">
            <svg class="icon minus">
                <use xlink:href="/img/sprites/sprite.svg#close-small"></use>
            </svg>
        </button>
    </div>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";

export default Vue.component("v-withstops", {
    data() {
        return {
            selected: 60
        };
    },
    props: ["data"],
    methods: {
        plus() {
            this.selected += 30;
        },
        minus() {
            if(this.selected <= 60) return false;
            this.selected -= 30;
        },
        remove() {
            this.$emit("remove", this.data);
        }
    }
});
</script>
