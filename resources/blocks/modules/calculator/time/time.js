import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";

Vue.component("v-time", {
  template: `
    <div class="custom-time" v-click-outside="close">
    <div class="custom-time__head" :class="{'error': error}" @click="toggle"><span>{{ hours | toNormNumber }}:{{ minutes | toNormNumber }} {{ ampm }}</span>
      <svg class="icon arrow-down">
        <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
      </svg>
    </div>
    <div class="custom-time__dropdown" v-show="opened" >
      <div class="custom-time__dropdown-head"><span :class="{ 'active': !pm }" @click="pm = false">AM</span>
        <button type="button" @click="pm = !pm">
          <svg class="icon icn-arrows-nocollor">
            <use xlink:href="img/sprites/sprite.svg#icn-arrows-nocollor"></use>
          </svg>
        </button>
        <span :class="{ 'active': pm }" @click="pm = true">PM</span></div>
      <div class="custom-time__dropdown-content">
        <div class="num-select">
          <button class="plus" type="button" @click="hPlus">
            <svg class="icon arrow-down">
              <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
            </svg>
          </button>
          <span>{{ hours | toNormNumber }}</span>
          <button class="minus" type="button" @click="hMinus">
            <svg class="icon arrow-down">
              <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
            </svg>
          </button>
        </div>
        <em>:</em>
        <div class="num-select">
          <button class="plus" type="button" @click="mPlus">
            <svg class="icon arrow-down">
              <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
            </svg>
          </button>
          <span>{{ minutes | toNormNumber }}</span>
          <button class="minus" type="button" @click="mMinus">
            <svg class="icon arrow-down">
              <use xlink:href="img/sprites/sprite.svg#arrow-down"></use>
            </svg>
          </button>
        </div>
      </div>
    </div>
    </div>
  `,
  data() {
    return {
      selectedTime: new Date().getHours() + ":" + new Date().getMinutes(),
      hours: new Date().getHours(),
      minutes: new Date().getMinutes(),
      opened: false,
      pm: true
    };
  },
  props: {
    error: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    ampm() {
      return this.pm ? "PM" : "AM";
    }
  },
  methods: {
    toggle() {
      this.opened = !this.opened;
    },
    close() {
      this.opened = false;
    },
    updateTime() {
      // this.$store.commit("changeState", {
      //   name: "time",
      //   content: this.hours + ":" + this.minutes
      // });
    },
    hPlus() {
      this.updateTime();
      // if(this.ampm === "PM") {
      //   this.hours = this.hours >= 23 ? 0 : this.hours + 1;
      // } else {
      // }
      this.hours = this.hours >= 12 ? 0 : this.hours + 1;
    },
    hMinus() {
      this.updateTime();
      // if(this.ampm === "PM") {
      //   this.hours = this.hours <= 0 ? 23 : this.hours - 1;
      // } else {
      // }
      this.hours = this.hours <= 0 ? 12 : this.hours - 1;
    },
    mPlus() {
      this.updateTime();
      this.minutes = this.minutes >= 59 ? 0 : this.minutes + 1;
    },
    mMinus() {
      this.updateTime();
      this.minutes = this.minutes <= 0 ? 59 : this.minutes - 1;
    }
  },
  watch: {
    // ampm() {
    //   if(this.ampm === "AM") {
    //     if(this.hours > 12) this.hours = 0;
    //   }
    // }
  },
  directives: {
    ClickOutside
  },
  filters: {
    toNormNumber(number) {
      return (number <= 9 ? "0" + number : number).toString();
    }
  }
});