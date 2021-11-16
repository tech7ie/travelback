<template>
    <article :style="'background-image: url(/'+data.image+')'">
        <b>{{ data.title }}</b>
        <template v-html="data.body"></template>
        <input type="checkbox" :name="'visitalong' + index" v-model="checked" style="position: absolute; width: 0; height: 0; opacity: 0;">
        <button type="button" :class="{added: addedPoint}" @click="buy">
            Add for <i :class="currency.toLowerCase() +'_money'"></i>{{ (parseFloat(data.price) * rate).toFixed(2) }}
            <span>
          <svg class="icon check">
            <use xlink:href="/img/sprites/sprite.svg#check"></use>
          </svg>
          added
        </span>
        </button>
    </article>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import {mapState} from "vuex";

export default Vue.component("v-article", {
    data() {
        return {
            checked: false
        };
    },
    props: ["data", "index", "addedPoint"],
    methods: {
        buy() {
            this.$emit("return", this.data, this.checked);
            this.checked = !this.checked;
        }
    },
    computed: {
        ...mapState({
            rate: store => store.rate,
            currency: store => store.currency,
        }),
    }
});
</script>
