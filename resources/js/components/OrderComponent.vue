<template>
    <form class="order js-form-validator" method="get" :action="getActions()">
        <div class="container">
            <div class="order__wrap">
                <div class="order__form">
                    <section>

                        <h2>Lead passenger</h2>
                        <div class="block-input">
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="block-input half">
                            <input name="first-name" placeholder="First name" required>
                        </div>
                        <div class="block-input half">
                            <input name="last-name" placeholder="Last name" required>
                        </div>
                        <div class="block-input">
                            <input class="js-input-mask" name="day-of-birth" data-mask="99.99.9999" placeholder="Day of birth" required>
                        </div>
                        <div class="input-block input-phone">
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="textarea-block">
                            <textarea name="comment" placeholder="Comment"></textarea>
                        </div>
                    </section>
                    <section class="--two">
                        <h2>Pick up and drop-off</h2><em>You can add or change these up to 24 hours before departure.</em>
                        <div class="block-input">
                            <input name="pickup-address" placeholder="Pickup address" required>
                        </div>
                        <div class="block-input">
                            <input name="drop-off-address" placeholder="Drop-off address" required>
                        </div>
                    </section>
                    <section class="--last">
                        <div class="order__payment">
                            <div class="order__payment-item">
                                <div class="order__payment-wrap">
                                    <h2>Payment</h2>
                                    <div class="checkbox --violet">
                                        <input type="radio" data-payment-check="1" id="check-strip" name="payment" checked>
                                        <label for="check-strip"><img src="/img/stripe.png" alt="stripe"></label>
                                    </div>
                                    <div class="checkbox --orange">
                                        <input type="radio" data-payment-check="2" id="check-cash" name="payment">
                                        <label for="check-cash">
                                            <svg class="icon">
                                                <use xlink:href="/img/sprites/sprite.svg#users"></use>
                                            </svg><span>Cash</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="order__payment-item">
                                <div class="order__payment-type --violete active" data-payment-content="1">
                                    <h4>Pay in Stripe</h4>
                                    <ul>
                                        <li v-for="(item, index) in payment_methods">
                                            <img :src="item['img']">
                                        </li>
                                    </ul>
                                </div>
                                <div class="order__payment-type" data-payment-content="2"><b>Pay your driver directly at the end of your trip.</b>
                                    <p>- Pay in any currency.</p>
                                    <p>- Gratuity isn’t included in the total price. While not required, if you had a great trip, you can reward your driver with an optional tip (10% is sufficient).</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <aside class="order__aside">
                    <div class="order__aside-wrap">
                        <div class="order-sum js-order-sum-toggle">
                            <div class="order-sum__title-mobile"><b>€136</b><em>VAT included</em>
                                <div class="tickets__footer-info">
                                    <div><span>1-3</span>
                                        <svg class="icon">
                                            <use xlink:href="/img/sprites/sprite.svg#users"></use>
                                        </svg>
                                    </div>
                                    <div><span>3x</span>
                                        <svg class="icon">
                                            <use xlink:href="/img/sprites/sprite.svg#suitecase"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="arrow">
                                    <svg class="icon">
                                        <use xlink:href="/img/sprites/sprite.svg#arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="order-sum__head">
                                <h2>Trip summary</h2><a href="#">Edit itinerary</a>
                            </div>
                            <div class="order-sum__country">
                                <div class="order-sum__country-item">
                                    <b>{{selected.orderRoute['from']}}</b>
                                    <span>Departure: {{ selected.orderRoute.route_start | moment("ddd, MMM, D, h:mm A") }}</span>
                                </div>
                                <div class="order-sum__country-item">
                                    <b>{{selected.orderRoute['to']}}</b>
                                    <span>Estimated arrival: {{ selected.orderRoute.route_end | moment("add", getExtraMinues + " m", "ddd, MMM, D, h:mm A") }}</span>

                                </div>
                            </div>
                            <div class="order-sum__cars">
                                <div><a href="Other-cars">Other cars</a></div>
                                <div class="order-sum__cars-item tickets__footer">
                                    <template v-for="(item, index) in selected.passangers">
                                        <i><img :src="'/'+ item['image']" alt="sedan"></i>
                                        <div class="tickets__footer-info">
                                            <h4>{{item['title']}}</h4><em>{{item['brand']}}</em>
                                            <div><span>{{item['places_min']}}-{{item['places_max']}}</span>
                                                <svg class="icon">
                                                    <use xlink:href="/img/sprites/sprite.svg#users"></use>
                                                </svg>
                                            </div>
                                            <div><span>3x</span>
                                                <svg class="icon">
                                                    <use xlink:href="/img/sprites/sprite.svg#suitecase"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div class="order-sum__footer">
                                <div><span>Total (EUR)</span><em>VAT included</em></div>
                                <div><b>€{{selected['price']}}</b></div>
                            </div>
                        </div>
                        <div class="order-sum__submit">
                            <button class="btn"><span>confirm and pay €{{selected['price']}}*</span></button><b>* Your payment (approx. A€{{selected['price']}}) will be taken in EUR. It's €648. The actual amount in AUD depends on your bank's exchange rate.</b>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </form>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";
import {mapState} from "vuex";

export default Vue.component("v-order-route", {
    data() {
        return {
            checked: false
        };
    },
    props: ["data", "index", "addedPoint", "payment_methods"],

    mounted() {
    },
    methods: {
        getActions(){
            return '/' + window.App.language + '/' + 'order-success'
        },
        buy() {
            this.$emit("return", this.data, this.checked);
            this.checked = !this.checked;
        }
    },
    computed: {
        ...mapState({
            cart: store => store.cart,
            count: store => store.count,
            route: store => store.route,
            points: store => store.points,
            selected: store => store.selected,
        }),
        getExtraMinutes(){
            let extraMinutes = 0;
            this.points.forEach(item => {
                extraMinutes += item.extra;
            });
            return extraMinutes;
        },
    }
});
</script>
