@extends('layouts.app')

@section('content')
    <div class="popups-wrap" style="height: 100vh;">
        <button data-fancybox data-src="#select-ride">#select-ride</button>
        <button data-fancybox data-src="#login">#login</button>
        <button data-fancybox data-src="#forgotpass">#forgotpass</button>
        <button data-fancybox data-src="#success">#success</button>
        <button data-fancybox data-src="#chg-pass">#chg-pass</button>
    </div>
    <div class="popup --xl" id="select-ride">
        <form class="popup__wrap">
            <h3>Select your ride</h3>
            <div class="popup-select-rider">
                <input id="select-auto-1" type="radio" name="select-ride" checked>
                <label for="select-auto-1">
                    <div class="tickets__footer"><i><img src="/img/sedan.png" alt="sedan"></i>
                        <div class="tickets__footer-info">
                            <h4>Luxury sedan</h4><em>Mercedes Benz E-Class</em>
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
                        <div class="tickets__footer-price"><b>€929</b></div>
                    </div>
                </label>
                <input id="select-auto-2" type="radio" name="select-ride">
                <label for="select-auto-2">
                    <div class="tickets__footer"><i><img src="/img/sedan.png" alt="sedan"></i>
                        <div class="tickets__footer-info">
                            <h4>Luxury sedan</h4><em>Mercedes Benz E-Class</em>
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
                        <div class="tickets__footer-price"><b>€929</b></div>
                    </div>
                </label>
            </div>
            <button class="btn-submit --simple --no-opacity --sm"><span>Save</span></button>
        </form>
    </div>
    <div class="popup --sm popup-login" id="login">
        <div class="popup__wrap">
            <h3 class="--center">Login in</h3>
            <form class="js-form-validator">
                <div class="input-block">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="input-block">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <button class="btn-submit --simple --no-opacity"><span>Save</span></button><a href="#Forgot-password">Forgot password</a>
            </form>
        </div>
    </div>
    <div class="popup --sm popup-login" id="forgotpass">
        <div class="popup__wrap">
            <h3 class="--center">Forgot password</h3>
            <form class="js-form-validator">
                <div class="input-block">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <button class="btn-submit --simple --no-opacity"><span>Save</span></button>
            </form>
        </div>
    </div>
    <div class="popup --sm popup-success" id="success">
        <form class="popup__wrap js-form-validator"><img src="/img/success.svg" alt="success icon">
            <h3 class="--center">Check your mail</h3>
        </form>
    </div>
    <div class="popup --md popup-chgpass" id="chg-pass">
        <div class="popup__wrap">
            <h3 class="--center">Login in</h3>
        </div>
        <form class="js-form-validator">
            <div class="input-block input-password"><em>Old password</em>
                <div>
                    <button type="button">
                        <svg class="icon">
                            <use xlink:href="/img/sprites/sprite.svg#eye"></use>
                        </svg>
                    </button>
                    <input type="password" name="ol-pass" required>
                </div>
            </div>
            <div class="input-block input-password half"><em>New password</em>
                <div>
                    <button type="button">
                        <svg class="icon">
                            <use xlink:href="/img/sprites/sprite.svg#eye"></use>
                        </svg>
                    </button>
                    <input type="password" name="new-pass" required>
                </div>
            </div>
            <div class="input-block input-password half"><em>Repeat new password</em>
                <div>
                    <button type="button">
                        <svg class="icon">
                            <use xlink:href="/img/sprites/sprite.svg#eye"></use>
                        </svg>
                    </button>
                    <input type="password" name="rep-pass" required>
                </div>
            </div><em>At least 8 characters, at least one capital letter</em>
            <button class="btn-submit --simple --no-opacity"><span>Save</span></button>
        </form>
    </div>
@endsection
