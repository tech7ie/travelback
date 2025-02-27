import Vue from "vue/dist/vue.esm.browser.min";

Vue.component("v-article", {
  template: `
    <article :style="'background-image: url('+data.img+')'">
      <b>{{ data.title }}</b>
      <p>{{ data.text }}</p>
      <input type="checkbox" :name="'visitalong' + index" v-model="checked" style="position: absolute; width: 0; height: 0; opacity: 0;">
      <button type="button" :class="{added: checked}" @click="buy">
        Add for €{{ data.price }}
        <span>
          <svg class="icon check">
            <use xlink:href="img/sprites/sprite.svg#check"></use>
          </svg>
          added
        </span>
      </button>
    </article>
  `,
  data() {
    return {
      checked: false
    };
  },
  props: ["data", "index"],
  methods: {
    buy() {
      this.$emit("return", this.data, this.checked);
      this.checked = !this.checked;
    }
  }
});