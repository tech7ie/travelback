<template>
    <div class="popup_wrapper fancybox__container" id="popup_box" v-show="active" @click="close">
        <modal v-if="showLoginModal" @close="closeModal()">
            <div class="popup --sm popup-login" id="login" v-show="form === '#login'">
                <div class="popup__wrap">
                    <h3 class="--center">{{ $t('Login in') }}</h3>
                    <form @submit.prevent="loginRequest" method="POST" class="js-form-validator">
                        <!--                    <form method="POST" class="js-form-validator" action="/en/login">-->
                        <input type="hidden" name="_token" :value="csrf">
                        <div class="input-block">
                            <input type="email" placeholder="Email" name="email" required>
                        </div>
                        <div class="input-block">
                            <input type="password" placeholder="Password" name="password" required>
                        </div>
                        <button type="submit" class="btn-submit --simple --no-opacity"><span>{{ $t('Save') }}</span></button>
                        <a @click="openForgot">Forgot password</a>
                        <a @click="openRegistration">Registration</a>
                    </form>
                </div>
                <button @click="closeModal()"
                        class="carousel__button is-close"
                        title="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1">
                        <path d="M20 20L4 4m16 0L4 20"></path>
                    </svg>
                </button>
            </div>
        </modal>
        <modal v-if="showForgotModal" @close="closeModal()">
            <div class="popup --sm popup-forgotpass" id="forgotpass" v-show="form === '#forgotpass'">
                <div class="popup__wrap">
                    <h3 class="--center">{{ $t('Forgot password') }}</h3>
                    <form class="js-form-validator">
                        <input type="hidden" name="_token" :value="csrf">
                        <div class="input-block">
                            <input type="email" placeholder="Email" name="email" required>
                        </div>
                        <button class="btn-submit --simple --no-opacity"><span>{{ $t('Save') }}</span></button>
                    </form>
                </div>
                <button @click="closeModal()"
                        class="carousel__button is-close"
                        title="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1">
                        <path d="M20 20L4 4m16 0L4 20"></path>
                    </svg>
                </button>
            </div>
        </modal>
        <modal v-if="showRegisterModal" @close="closeModal()">
            <div class="popup --sm popup-registration" id="registration" v-show="form === '#registration'">
                <div class="popup__wrap">
                    <h3 class="--center">{{ $t('Register') }}</h3>
                    <!--                <form method="POST" class="js-form-validator" action="en/register">-->
                    <form @submit.prevent="registerRequest" method="POST" class="js-form-validator">
                        <input type="hidden" name="_token" :value="csrf">
                        <div class="input-block">
                            <input type="email" placeholder="Email" name="email" required>
                        </div>
                        <div class="input-block">
                            <input type="password" placeholder="Password" name="password" required>
                        </div>
                        <div class="input-block">
                            <input type="password" placeholder="Password confirm" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn-submit --simple --no-opacity"><span>{{ $t('Register') }}</span></button>
                    </form>
                </div>
                <button @click="closeModal()"
                        class="carousel__button is-close"
                        title="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1">
                        <path d="M20 20L4 4m16 0L4 20"></path>
                    </svg>
                </button>
            </div>
        </modal>
        <div class="popup --sm popup-success" id="message_box" style="display:none">
            <a id="message_box_request" data-fancybox data-src="#message_box" alt="user" style="display: none"></a>
            <form class="popup__wrap js-form-validator">
                <img src="/img/success.svg" alt="success icon">
                <h3 class="--center">{{ popupMessage }}</h3>
            </form>
        </div>
    </div>
</template>
<script>
import Vue from "vue/dist/vue.esm.browser.min";

import Swiper from 'swiper/bundle';

export default Vue.component("v-popups", {
    props: {
        auth: false,
        csrf: '',
    },
    data() {
        return {
            showLoginModal: false,
            showRegisterModal: false,
            showForgotModal: false,
            active: false,
            form: '',
            popupMessage: '',
            pageUrl: window.location.href,
            link: '',
            popups: ['#login', '#registration'],
            loginForm: {
                email: '',
                password: ''
            },
            registerForm: {
                email: '',
                password: '',
                rePassword: ''
            }
        };
    },
    mounted() {
        if (document.location.hash === '#login') {
            this.showLoginModal = true
            this.active = true;
            this.form = '#login'
        }
        window.addEventListener('hashchange', this.hashChange.bind(this))
    },
    methods: {

        loginRequest(e) {
            const formData = new FormData(e.target);
            const formProps = Object.fromEntries(formData);
            axios.post('/' + window.App.language + '/login', formProps
            )
                .then(res => {
                    console.log('getPlaces ress;', res);
                    if (res) {
                        window.location.href = '/' + window.App.language + '/cabinet'
                    }
                }).catch(e => {
                this.popupMessage = e?.response?.data?.message
                document.getElementById('message_box_request').click()
            })
        },

        registerRequest(e) {
            const formData = new FormData(e.target);
            const formProps = Object.fromEntries(formData);
            axios.post('/' + window.App.language + '/register', formProps
            // axios.post('/register', formProps
            )
                .then(res => {
                    console.log(res);
                    // if (res) {
                    //     window.location.href = '/' + window.App.language
                    // }

                    this.popupMessage = 'Success !!!'
                    document.getElementById('message_box_request').click()
                }).catch(e => {
                let errors = e?.response?.data?.errors || []

                this.popupMessage += this.$t(e?.response?.data?.errors?.email[0]) || ''
                this.popupMessage += this.$t(e?.response?.data?.errors?.password[0]) || ''
                //
                // console.log(errors);
                // errors.forEach(e=>{
                //     console.log(e);
                //     this.popupMessage += e
                // })

                // this.popupMessage = e?.response?.data?.message
                document.getElementById('message_box_request').click()
            })
        },

        hashChange() {
            if (this.$data.popups.indexOf(location.hash) >= 0) {
                if (location.hash === '#login') {
                    this.$data.showLoginModal = true
                }
                if (location.hash === '#registration') {
                    this.$data.showRegisterModal = true
                }
                this.$data.active = true
                this.$data.form = location.hash
            }

        },

        closeModal() {
            console.log('closeLogin');
            this.showLoginModal = false
            this.showRegisterModal = false
            this.showForgotModal = false
            this.active = false;
            this.form = ''
            location.hash = ''

        },

        openRegistration() {
            this.closeModal()
            this.showRegisterModal = true
            this.active = true;
            this.form = '#registration'

        },

        openForgot() {
            this.closeModal()
            this.showForgotModal = true
            this.active = true;
            this.form = '#forgotpass'
        },
        close(e) {
            console.log(e.target.id);
            if (e.target.id === 'popup_box') {
                this.active = false;
                this.form = ''
                location.hash = ''
            }

        }
    },
    watch: {
        'location.hash': function () {
            console.log(window.location.href);
            this.link = window.location.href
        }
    },
});
</script>
<style scoped>

.popup {
    display: inherit;
    position: relative;
}

.popup_wrapper {
    justify-content: center;
    align-items: center;
    -webkit-backdrop-filter: blur(3px);
    backdrop-filter: blur(3px);
    background: rgba(0, 0, 0, .7);
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    direction: ltr;
    margin: 0;
    padding: 0px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    color: rgb(55, 65, 81);
    -webkit-tap-highlight-color: transparent;
    overflow: hidden;
    z-index: 1050;
    outline: 0;
    -webkit-transform-origin: top left;
    -ms-transform-origin: top left;
    transform-origin: top left;
    --carousel-button-width: 48px;
    --carousel-button-height: 48px;
    --carousel-button-svg-width: 24px;
    --carousel-button-svg-height: 24px;
    --carousel-button-svg-stroke-width: 2.5;
    --carousel-button-svg-filter: drop-shadow(1px 1px 1px rgba(0, 0, 0, 0.4))
}
</style>
