import Vue from "vue/dist/vue.esm.browser.min";

Vue.component("v-requirements", {
  template: `
  <div class="requirements">
    <em>{{ textLength }}/100</em>
    <textarea name="requirements" placeholder="Your text" maxlength="100" @input="calcLength" @change="calcLength" @keyup="calcLength"></textarea>
  </div>
  `,
  data() {
    return {
      textLength: 0
    };
  },
  methods: {
    calcLength(event) {
      if(event.target.value.length > 100) return false;
      this.textLength = event.target.value.length;
    }
  }
});