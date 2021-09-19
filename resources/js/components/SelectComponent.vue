<template>
    <div class="custom-select" >
        <div class="custom-select__item" :class="{'--active': openedFrom }">
            <div class="custom-select__head" data-input-parent :class="{error: errorFrom}">
                <input
                    name="from"
                    placeholder="From"
                    @input="inputFrom"
                    required="required"
                    type="search"
                    v-model="selectedFrom"
                    autocomplete="off"
                    @keyup="openedFrom = true"
                    @blur="toggle"
                />
            </div>
            <div class="custom-select__options" :class="{ '--opened': openedFrom }">
                <div class="custom-select__option" @click="selectFrom(item)" v-for="(item, index) in list" :key="index">
                    <b>{{ item.city }}</b>
                    <em>{{ item.country }}</em>
                </div>
            </div>
        </div>
        <div class="custom-select__change" @click="change">
            <svg class="icon">
                <use xlink:href="/img/sprites/sprite.svg#icn-arrows2"></use>
            </svg>
        </div>
        <div class="custom-select__item" :class="{'--active': openedTo }">
            <div class="custom-select__head" data-input-parent :class="{error: errorTo}">
                <input
                    name="to"
                    placeholder="To"
                    @input="inputTo"
                    required="required"
                    type="search"
                    v-model="selectedTo"
                    autocomplete="off"
                    @keyup="openedTo = true"
                    @blur="toggle"
                />
            </div>
            <div class="custom-select__options" :class="{ '--opened': openedTo }">
                <div class="custom-select__option" @click="selectTo(item)" v-for="(item, index) in list" :key="index">
                    <b>{{ item.city }}</b>
                    <em>{{ item.country }}</em>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";
export default
Vue.component("v-select", {
  data() {
    return {
      openedFrom: false,
      openedTo: false,
      selectedFrom: "",
      errorFrom: false,
      selectedTo: "",
      errorTo: false,
      firstStart: false,
      list: [
        {
          city: "Berchtesgaden",
          country: "Germany"
        },
        {
          city: "Berat",
          country: "Albania"
        },
        {
          city: "Berchtesgaden",
          country: "Germany"
        }
      ],
    };
  },
  props: {
    errorFirst: {
      type: Boolean,
      default: false
    },
    returnFrom: {
      type: Function
    }
  },
  created() {
    this.firstStart = true;
  },
  computed: {
    // errorFrom() {
    //   return this.$store.state.errorFrom;
    // }
  },
  methods: {
    updateError() {
      // this.errorFrom = this.selectedFrom.length <= 2;
      // this.errorTo = this.selectedTo.length <= 2;
    },
    selectFrom(item) {
      // this.openedFrom = false;
      this.selectedFrom = item.city;
      this.updateError();
    },
    inputFrom() {
      this.updateError();
    },
    selectTo(item) {
      // this.openedTo = false;
      this.selectedTo = item.city;
      this.updateError();
    },
    inputTo() {
      this.updateError();
    },
    change() {
      let from = this.selectedFrom;
      let to = this.selectedTo;
      this.selectedFrom = to;
      this.selectedTo = from;
      this.updateError();
    },
    toggle() {
      setTimeout(() => {
        this.openedFrom = false;
        this.openedTo = false;
      }, 300);
    }
  },
  directives: {
    ClickOutside
  }
});
</script>
