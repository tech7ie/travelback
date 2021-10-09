<template>
    <div class="select-humans" v-click-outside="close">
        <input type="number" required name="passengers" :value="(adults + children == 0 ? '' : adults + children)">
        <input type="number" required name="luggage" :value="luggage">
        <div class="select-humans__head" @click="opened = !opened">
            <div :class="{error: errorHumans}"><em>passengers:</em><span>{{ adults + children }}</span>
                <svg class="icon users">
                    <use xlink:href="/img/sprites/sprite.svg#users"></use>
                </svg>
            </div>
            <div><em>luggage: {{ data }}</em><span>{{ luggage }}</span>
                <svg class="icon suitecase">
                    <use xlink:href="/img/sprites/sprite.svg#suitecase"></use>
                </svg>
            </div>
        </div>
        <div class="select-humans__list" v-show="opened">
            <div class="select-humans__list-item">
                <div><span>Adults</span><em>Age: 12+</em></div>
                <v-incdec :value="adults" :min="1" @value="changeValue('adults', $event)"></v-incdec>
            </div>
            <div class="select-humans__list-item">
                <div><span>Children</span><em>Age: 0-12</em></div>
                <v-incdec @value="changeValue('children', $event)"></v-incdec>
            </div>
            <div class="select-humans__list-item">
                <div><span>luggage</span><em>Sets of bags</em></div>
                <v-incdec :value="luggage" :min="(adults + children)"
                          :sync="true"
                          @value="changeValue('luggage', $event)"
                ></v-incdec>
            </div>
        </div>
    </div>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import ClickOutside from "vue-click-outside";

export default Vue.component("v-humans", {
    data() {
        return {
            opened: false,
            number: 0,
            adults: 1,
            children: 0,
            luggage: 1,
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
            this.returnValues();
            this.luggage = (this.adults + this.children) > this.luggage ? (this.adults + this.children) : this.luggage;
            this.returnValues();
        },
        returnValues() {
            this.$emit("return", {
                passengers: this.adults + this.children,
                luggage: (this.adults + this.children) < this.luggage ? this.luggage : (this.adults + this.children)
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

</script>
