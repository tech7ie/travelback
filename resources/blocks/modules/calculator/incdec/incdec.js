import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";

Vue.component("v-incdec", {
  template: `
    <div class="incdec">
      <div class="incdec__plus" @click="minus">
        <svg class="icon minus">
          <use xlink:href="/img/sprites/sprite.svg#minus"></use>
        </svg>
      </div>
      <div class="incdec__input">
        <span>{{ number }}</span>
      </div>
      <div class="incdec__minus" @click="plus">
        <svg class="icon plus">
          <use xlink:href="/img/sprites/sprite.svg#plus"></use>
        </svg>
      </div>
    </div>
  `,
  data() {
    return {
      number: this.value
    };
  },
  props: {
    value: {
      type: Number,
      default: 0
    },
    min: {
      type: Number,
      default: 0
    },
    sync: {
      type: Boolean,
      default: false
    }
  },
  created() {
    this.$emit("value", this.number);
  },
  methods: {
    plus() {
      this.number = this.number + 1;
      this.$emit("value", this.number);
    },
    minus() {
      if(this.number <= this.min) return false;
      this.number = this.number - 1;
      this.$emit("value", this.number);
    }
  },
  watch: {
    value() {
      if(this.sync) {
        if(this.number < this.value) {
          this.number = this.value;
          this.$emit("value", this.number);
        }
      }
    }
  },
  directives: {
    ClickOutside
  }
});
