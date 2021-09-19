import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";

Vue.component("v-extrastops-item", {
  template: `
    <div class="extrastops" v-click-outside="close" :class="{ opened }" style="z-index: 9; position:relative;">
      <div class="extrastops__item">
        <input type="hidden" :value="selected" :name="'extrastops' + index">
        <span>Stops {{ index + 1}}</span>
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
  `,
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

Vue.component("v-extrastops", {
  template: `
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
  `,
  data() {
    return {
      opened: true,
      list: [60, 80, 100, 120, 140],
      selected: 0,
      list: []
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
      console.log(index)
      this.list.splice(this.list.indexOf(this.list[index]), 1);
    }
  },
  directives: {
    ClickOutside
  }
});