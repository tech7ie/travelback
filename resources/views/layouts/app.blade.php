<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $content['meta_title'] ?? config('app.name', 'Laravel')  }}</title>
    <!-- CSRF Token -->
    <meta name="description"
          content="{{ $content['meta_description'] ?? ''  }}">
    <meta name="keywords"
          content="{{ $content['meta_keywords'] ?? ''  }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#fff">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/favicons/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" sizes="16x16" href="{{ asset('img/favicons/favicon-16x16.png') }}" type="image/png">
    <link rel="icon" sizes="32x32" href="{{ asset('img/favicons/favicon-32x32.png') }}" type="image/png">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('img/favicons/apple-touch-icon-precomposed.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicons/apple-touch-icon.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicons/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/favicons/apple-touch-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/favicons/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicons/apple-touch-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/favicons/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/favicons/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/favicons/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/favicons/apple-touch-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('img/favicons/apple-touch-icon-167x167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-touch-icon-180x180.png') }}">
    <link rel="apple-touch-icon" sizes="1024x1024" href="{{ asset('img/favicons/apple-touch-icon-1024x1024.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&amp;display=swap" rel="stylesheet">

    <script>
        window.App = {!! json_encode([
        'user' => Auth::user(),
        'signedIn' => Auth::check(),
        'language' => app()->getLocale()
    ]) !!};
    </script>
    <link rel="stylesheet" href="{{ asset('styles/main.min.css') }}">
</head>
<body>
<div id="app">
    <v-init auth="{{(Auth::check())}}" ></v-init>
    <svg style="width: 0; height: 0; overflow: hidden; position: absolute; left: -100%;" width="120" height="240" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <lineargradient id="gradient">
                <stop offset="0%" stop-color="#ec824a"></stop>
                <stop offset="100%" stop-color="#F6B22E"></stop>
            </lineargradient>
        </defs>
    </svg>
    <header class="header">
        <div class="container">
            <div class="header__wrap"><a class="header__logo" href="{{ route('home', app()->getLocale()) }}"><img src="{{asset('img/logo.png')}}" alt="logo"></a>
                <div class="header__menu">
                    <nav>
                        <ul>
                            <li><a href="#">Company</a></li>
                            <li><a href="#">Discover</a></li>
                            <li><a href="{{ route('routes', app()->getLocale()) }}">Routes</a></li>
                            <li><a href="#">Become a partner</a></li>
                            <li><a href="{{ route('about', app()->getLocale()) }}">About</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="header__control">
                    <div class="header__currency">
                        <div class="custom-select">
                            <v-currency-select
                                currencylist="{{json_encode(Config::get('app.currency_list'))}}"
                                currentcurrency="{{\App\Helper\Helper::getCurrency()}}"
                                currentcurrencyexchanges="{{json_encode(\App\Helper\Helper::getCurrencyExchanges())}}"
                            ></v-currency-select>
                        </div>
                    </div>
                    <div class="header__lang">
                        <div class="custom-select --right-desktop">
                            <v-language-select
                                currentlang="{{App::getLocale()}}"
                                languages="{{json_encode(Config::get('languages'))}}"
                            ></v-language-select>
                        </div>
                    </div>
                    @auth
                        <div class="header__user">
                            <a href="{{ route('cabinet', app()->getLocale()) }}" alt="user">
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#user"></use>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="header__user">
                            <a id="auth_button" data-fancybox data-src="#login" alt="user">
                                <svg class="icon">
                                    <use xlink:href="/img/sprites/sprite.svg#user"></use>
                                </svg>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
            <div class="header__mobile">
                <div class="header__burger js-menu-burger"><span><i></i></span></div>
                <a class="header__mobile-logo" href="#logo"><img src="/img/svg/logo.svg" alt="logo"></a>
                <div class="header__user"><a href="#user" alt="user">
                        <svg class="icon">
                            <use xlink:href="/img/sprites/sprite.svg#user"></use>
                        </svg>
                    </a></div>
            </div>
        </div>
    </header>
    @yield('content')
    <x-footer />
</div>
@auth

@else
    <div class="popup --sm popup-forgotpass" id="forgotpass">
        <div class="popup__wrap">
            <h3 class="--center">{{ __('Forgot password') }}</h3>
            <form class="js-form-validator">
                <div class="input-block">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <button class="btn-submit --simple --no-opacity"><span>{{ __('Save') }}</span></button>
            </form>
        </div>
    </div>
    <div class="popup --sm popup-login" id="login">
        <div class="popup__wrap">
            <h3 class="--center">{{ __('Login in') }}</h3>
            <form method="POST" class="js-form-validator" action="{{ route('login', app()->getLocale()) }}">
                @csrf
                <div class="input-block">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="input-block">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <button class="btn-submit --simple --no-opacity"><span>{{ __('Save') }}</span></button>
                <a data-fancybox data-src="#forgotpass">Forgot password</a>
                <a data-fancybox data-src="#registration">Registration</a>
            </form>
        </div>
    </div>
    <div class="popup --sm popup-registration" id="registration">
        <div class="popup__wrap">
            <h3 class="--center">{{ __('Register') }}</h3>
            <form method="POST" class="js-form-validator_" action="{{ route('register', app()->getLocale()) }}">
                @csrf
                <div class="input-block">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="input-block">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="input-block">
                    <input type="text" placeholder="Password confirm" name="password" required>
                </div>
                <button class="btn-submit --simple --no-opacity"><span>{{ __('Register') }}</span></button>
                <a data-fancybox data-src="#forgotpass">Forgot password</a>
            </form>
        </div>
    </div>
@endauth
</body>
<script src="{{ asset('js/app.js') }}" defer></script>
</html>
