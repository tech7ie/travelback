<template>
    <form id="payment-form" class="order js-form-validator" :data-submit="submit_form">
        <input type="text" name="csrf" :value="csrf" hidden>
        <div class="container">
            <div class="order__wrap">
                <div class="order__form">
                    <section>
                        <h2>Lead passenger</h2>
                        <div class="block-input">
                            <input v-model="orderDetails.email" type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="block-input half">
                            <input v-model="orderDetails.first_name" name="first-name" placeholder="First name" required>
                        </div>
                        <div class="block-input half">
                            <input v-model="orderDetails.last_name" name="last-name" placeholder="Last name" required>
                        </div>
                        <div class="block-input">
                            <input v-model="orderDetails.birth_day" id="dayofbirth" class="js-input-mask" name="day-of-birth" data-mask="99.99.9999" placeholder="Day of birth" required>
                        </div>
                        <div class="input-block input-phone">
                            <input v-model="orderDetails.phone" type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="textarea-block">
                            <textarea v-model="orderDetails.comment" name="comment" placeholder="Comment"></textarea>
                        </div>
                    </section>
                    <section class="--two">
                        <h2>Pick up and drop-off</h2><em>You can add or change these up to 24 hours before departure.</em>
                        <div class="block-input">
                            <input v-model="orderDetails.pickup_address" name="pickup-address" placeholder="Pickup address" required>
                        </div>
                        <div class="block-input">
                            <input v-model="orderDetails.drop_off_address" name="drop-off-address" placeholder="Drop-off address" required>
                        </div>
                    </section>

                    <p>Test Card</p>
                    <p>4242424242424242 12/25 123 12345</p>
                    <p>4000002500003155 12/25 123 12345</p>
                    <section class="--last">
                        <div class="order__payment">
                            <div class="order__payment-item">
                                <div class="order__payment-wrap">
                                    <h2>Payment</h2>
                                    <div class="checkbox --violet">
                                        <input v-model="payment_type" value="1" type="radio" data-payment-check="1" id="check-strip" name="payment">
                                        <label for="check-strip"><img src="/img/stripe.png" alt="stripe"></label>
                                    </div>
                                    <div class="checkbox --orange">
                                        <input v-model="payment_type" value="2" type="radio" data-payment-check="2" id="check-cash" name="payment">
                                        <label for="check-cash">
                                            <svg class="icon">
                                                <use xlink:href="/img/sprites/sprite.svg#users"></use>
                                            </svg>
                                            <span>Cash</span>
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
                                    <br>
                                    <div v-if="payment_type === 1" id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
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
                                    <b>{{ selected.orderRoute['from'] }}</b>
                                    <span>Departure: {{ selected.orderRoute.route_start | moment("ddd, MMM, D, h:mm A") }}</span>
                                </div>
                                <div class="order-sum__country-item">
                                    <b>{{ selected.orderRoute['to'] }}</b>
                                    <span>Estimated arrival: {{ selected.orderRoute.route_end | moment("add", getExtraMinues + " m", "ddd, MMM, D, h:mm A") }}</span>

                                </div>
                            </div>
                            <div class="order-sum__cars">
                                <div><a href="Other-cars">Other cars</a></div>
                                <div class="order-sum__cars-item tickets__footer">
                                    <template v-for="(item, index) in selected.passangers">
                                        <i><img :src="'/'+ item.car['image']" alt="sedan"></i>
                                        <div class="tickets__footer-info">
                                            <h4>{{ item.car['title'] }}</h4><em>{{ item.car['brand'] }}</em>
                                            <div><span>{{ item.car['places_min'] }}-{{ item.car['places_max'] }}</span>
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
                                <div><span>Total ({{ currency.toUpperCase() }})</span><em>VAT included</em></div>
                                <div><b>{{ currency.toUpperCase() + ' ' }} {{ selected['price'] }}</b></div>
                            </div>
                        </div>
                        <div class="order-sum__submit">
                            <button class="btn" type="submit">
                                <span>confirm and pay {{ currency.toUpperCase() + ' ' }}{{ selected['price'] }}*</span></button>
                            <b>* Your payment (approx. A€136) will be taken in EUR. It's €648. The actual amount in AUD depends on your bank's exchange rate.</b>
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
import initValidation from "./helper/validator";

export default Vue.component("v-order-route", {
    data() {
        return {
            payment_type: 1,
            checked: false,
            stripeToken: null,
            orderDetails: {
                email: '',
                first_name: '',
                last_name: '',
                phone: '',
                birth_day: '',
                comment: '',
                pickup_address: '',
                drop_off_address: '',
            }
        };
    },
    props: ["data", "index", "addedPoint", "payment_methods", "csrf"],

    mounted() {
        initValidation(".js-form-validator");

        let $this = this;
        document.addEventListener("bouncerFormValid", function (el) {
            if ($this.payment_type === 1) {
                stripe.createToken(card).then(function (result) {
                    console.log('createToken: ', result);
                    if (result.error) {
                        // Inform the customer that there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        $this.stripeToken = result.token.id
                        $this.submit_form(el)
                    }
                });
            } else {
                $this.submit_form(el)

            }
        });

        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '16px',
                color: '#32325d',
            },
        };

        var stripe = Stripe('pk_test_51JnNJWEyrjgWWtiTKguEGz7IQ6Lu7bIEgNoL5aMQ6X6qbDlIIqqEnB0nR1VyZQ3cuoOMMIkg7NOMYRuKYzlufLdg00pJ2qrBa3');
        var elements = stripe.elements();


        var card = elements.create('card', {style: style});

        card.mount('#card-element');

        document.addEventListener('DOMContentLoaded', function () {
            let dayofbirth = $("#dayofbirth");
            dayofbirth.mask("99.99.9999");
            var phoneInputID = "#phone";
            var input = document.querySelector(phoneInputID);
            var iti = window.intlTelInput(input, {
                separateDialCode: true,
                formatOnDisplay: true,
                geoIpLookup: function (callback) {
                    $.get("http://ipinfo.io", function () {
                    }, "jsonp").always(function (resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "";
                        callback(countryCode);
                    });
                },
                hiddenInput: "full_number",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js"
            });

            $(phoneInputID).on("countrychange", function (event) {
                console.log('countrychange');
                var selectedCountryData = iti.getSelectedCountryData();

                var newPlaceholder = intlTelInputUtils.getExampleNumber(selectedCountryData.iso2, true, intlTelInputUtils.numberFormat.INTERNATIONAL),


                    mask = newPlaceholder.replace(/[1-9]/g, "0");

                // Apply the new mask for the input
                $(this).mask(mask);
            });

            iti.promise.then(function () {
                $(phoneInputID).trigger("countrychange");
            });
        });
    },
    methods: {
        getActions() {
            return '/' + window.App.language + '/' + 'order-success'
        },
        submit_form(e) {
            console.log(e);
            e.preventDefault()
            this.$emit("return", this.data, this.checked);
            this.checked = !this.checked;

            let data = this.cart
            data['order_details'] = this.orderDetails
            data['stripe_token'] = this.stripeToken
            data['payment_type'] = this.payment_type


            axios.post('/' + window.App.language + '/set_order', data)
                .then(res => {
                    console.log('getPlaces ress;', res);
                    this.places = res.data ?? [];
                    window.location.href = this.getOrderUrl();
                    this.$store.commit('setCart', []);
                    this.$store.commit('setRoute', []);
                    this.$store.commit('setSelected', []);
                    this.$store.commit('clearPoint');

                    window.location.href = this.getOrderUrl();
                }).catch(e=>{
                console.log(e);
                window.location.href = this.getOrderCancelUrl();
            })
        },
        getOrderSuccessUrl() {
            return '/' + window.App.language + '/order-success'
        },
        getOrderCancelUrl() {
            return '/' + window.App.language + '/order-cancel'
        },
    },
    computed: {
        ...mapState({
            cart: store => store.cart,
            count: store => store.count,
            route: store => store.route,
            points: store => store.points,
            selected: store => store.selected,
            rate: store => store.rate,
            currency: store => store.currency,
        }),
        getExtraMinutes() {
            let extraMinutes = 0;
            this.points.forEach(item => {
                extraMinutes += item.extra;
            });
            return extraMinutes;
        },
    }
});
</script>
