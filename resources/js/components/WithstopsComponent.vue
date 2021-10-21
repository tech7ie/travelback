<template>
    <div class="withstops__list-item">
        <i>
            <img :src="'/'+data.image" :alt="data.title"/>
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
            <div class="incdec__input"><span>{{ (data.durations + data.extra).toFixed(2) }} min</span></div>
            <input type="hidden" :name="'withstops-' + data.id" :value="selected">
            <div class="incdec__minus" @click="plus">
                <svg class="icon plus">
                    <use xlink:href="/img/sprites/sprite.svg#plus"></use>
                </svg>
            </div>
        </div>
        <b>{{ currency.toUpperCase() + ' ' }} {{ (rate * (data.price + ((data.extra_durations / 2) * ((data.extra / this.step))))).toFixed(2) }}</b>
        <button type="button" @click="remove">
            <svg class="icon minus">
                <use xlink:href="/img/sprites/sprite.svg#close-small"></use>
            </svg>
        </button>
    </div>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import {mapState} from "vuex";

export default Vue.component("v-withstops", {
    data() {
        return {
            selected: 0,
            step: 30
        };
    },
    props: ["data"],
    mounted() {
        this.selected = this.data.extra
    }, computed: {
        ...mapState({
            rate: store => store.rate,
            currency: store => store.currency,
        }),
    },
    methods: {
        plus() {
            this.selected += this.step;
            this.$emit("update_time", {data: this.data, extra: this.selected});
        },
        minus() {
            if (this.selected <= this.data.durations) return false;
            this.selected -= this.step;
            this.$emit("update_time", {data: this.data, extra: this.selected});
        },
        remove() {
            this.$emit("remove", this.data);
        }
    }
});
</script>
