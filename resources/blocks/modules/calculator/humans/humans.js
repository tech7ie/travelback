import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";

Vue.component("v-humans", {
  template: `
    <div class="select-humans" v-click-outside="close">
    <input type="number" required name="passangers" :value="(adults + children == 0 ? '' : adults + children)">
    <div class="select-humans__head" @click="opened = !opened">
      <div :class="{error: errorHumans}"><em>Passangers:</em><span>{{ adults + children }}</span>
        <svg class="icon users">
          <use xlink:href="/img/sprites/sprite.svg#users"></use>
        </svg>
      </div>
      <div><em>Lugguage: {{ data }}</em><span>{{ lugguage }}</span>
        <svg class="icon suitecase">
          <use xlink:href="/img/sprites/sprite.svg#suitecase"></use>
        </svg>
      </div>
    </div>
    <div class="select-humans__list" v-show="opened">
      <div class="select-humans__list-item">
        <div><span>Adults</span><em>Age: 12+</em></div>
        <v-incdec :value="1" :min="1" @value="changeValue('adults', $event)"></v-incdec>
      </div>
      <div class="select-humans__list-item">
        <div><span>Children</span><em>Age: 0-12</em></div>
        <v-incdec @value="changeValue('children', $event)"></v-incdec>
      </div>
      <div class="select-humans__list-item">
        <div><span>Lugguage</span><em>Sets of bags</em></div>
        <v-incdec :value="adults" :min="adults" :sync="true" @value="changeValue('lugguage', $event)"></v-incdec>
      </div>
    </div>
    </div>
  `,
  data() {
    return {
      opened: false,
      number: 0,
      adults: 0,
      children: 0,
      lugguage: 0,
      errorHumans: false
    };
  },
  props: ["data"],
  methods: {
    close() {
      this.opened = false;
    },
    changeValue(param, value) {
      this[param] = value;
      this.retrunValues();
    },
    retrunValues() {
      this.$emit("return", {
        passangers: this.adults + this.children,
        lugguage: this.lugguage
      });
    }
  },
  directives: {
    ClickOutside
  },
  watch: {
    adults() {
      this.errorHumans = (this.adults + this.children) <= 0;
    },
    children() {
      this.errorHumans = (this.adults + this.children) <= 0;
    }
  }
});
