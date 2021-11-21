<template>
    <article :style="'background-image: url(/'+data.image+')'">
        <div style="
      width: 19rem;
      background: rgba(0, 0, 0, .6);
      display: inline-table;
      justify-content: center;
      flex-direction: column;
      padding: 21px;
      border-radius: 22px;">
            <b>{{ data.title }}</b>
            <div :style="{'max-height':'60%', 'overflow':'hidden'}" v-html="data.body"></div>
            <input type="checkbox" :name="'visitalong' + index" v-model="checked" style="position: absolute; width: 0; height: 0; opacity: 0;">
            <button type="button" :class="{added: addedPoint}" @click="buy">
                {{$t('Add for')}} <i :class="currency.toLowerCase() +'_money'"></i>{{ (parseFloat(data.price) * rate).toFixed(2) }}
                <span>
          <svg class="icon check">
            <use xlink:href="/img/sprites/sprite.svg#check"></use>
          </svg>
                    {{$t('added')}}
        </span>
            </button>
        </div>
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
