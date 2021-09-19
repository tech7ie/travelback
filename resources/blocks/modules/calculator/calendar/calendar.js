import Vue from "vue/dist/vue.esm.browser.min";
import VCalendar from "v-calendar";
import ClickOutside from "vue-click-outside";
Vue.use(VCalendar);

Vue.component("v-custom-calendar", {
  template: `
    <div class="custom-calendar" v-click-outside="close">
    <div class="custom-calendar__btn" @click="opened = !opened"><span>{{ selectedDate }}</span>
      <svg class="icon calendar">
        <use xlink:href="/img/sprites/sprite.svg#calendar"></use>
      </svg>
    </div>
    <div class="calendar" v-show="opened">
      <input type="hidden" :value="selectedDate">
      <v-date-picker mode="single" :min-date="new Date()" :model-config="modelConfig" v-model="selectedDate" is-required  locale="en-EN"></v-date-picker>
    </div>
    </div>
  `,
  data() {
    return {
      opened: false,
      selectedDate: new Date().toLocaleDateString(),
      modelConfig: {
        type: "string",
        mask: "DD.MM.YYYY", // Uses 'iso' if missing
      },
      attrs: [
        {
          key: "today",
          highlight: "red",
          dates: new Date(),
        },
      ],
    };
  },
  computed: {
    calendarData() {
      return this.selectedDate ? (new Date(this.selectedDate).toLocaleDateString()) : "";
    }
  },
  methods: {
    close() {
      this.opened = false;
    }
  },
  watch: {
    selectedDate() {
      this.opened = false;
    }
  },
  directives: {
    ClickOutside
  }
});
