@extends('layouts.app')

@section('content')
    <div class="homehead">
        <div class="homehead__top">
            <div class="container">
                <div class="homehead__wrap">
                    <div class="homehead__form">
                        <div class="form-block">
                            <div class="form-block__wrap">
                                <div class="label">One way</div>
                                <div class="homehead-form form-vue calc" id="homehead-form">
                                    <v-calculator :request="{{json_encode($_GET)}}" :short="true" routes="{{$routes ?? []}}">

                                    </v-calculator>
{{--                                    <form class="js-homehead-form" data-submit="homeheadSubmit">--}}
{{--                                        <v-select name="from"></v-select>--}}
{{--                                        <div class="date-time">--}}
{{--                                            <v-custom-calendar routes="{{$routes ?? []}}"></v-custom-calendar>--}}
{{--                                            <v-time></v-time>--}}
{{--                                        </div>--}}
{{--                                        <v-humans></v-humans>--}}
{{--                                        <div class="form-vue__footer --line"><span>Can't find your destination?</span><a href="#">Request a custom route</a></div>--}}
{{--                                        <button class="btn-submit"><span>Search</span></button>--}}
{{--                                        <div class="label">Chauffeur will wait 15 minutes free of charge</div>--}}
{{--                                    </form>--}}
                                </div>
{{--                                <script>--}}
{{--                                    function homeheadSubmit(e) {--}}
{{--                                        console.log(e);--}}
{{--                                    }--}}

{{--                                </script>--}}
                            </div>
                        </div>
                    </div>
                    <div class="homehead__content">
                        <h1>{!! __("home.home_title") !!}</h1>
                        <div class="homehead__content-label"><i><img src="/img/logo-min.svg" alt="IMG"></i>
                            <div>{!! __("home.home_sub_title") !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="homehead-info">
            <div class="container">
                <div class="homehead-info__grid">
                    <div class="homehead-info__item"><i><img src="/img/map.svg" alt="IMG"></i>
                        <div><b>From A to B service</b><span>Get easily from your starting to the final spot.</span></div>
                    </div>
                    <div class="homehead-info__item"><i><img src="/img/milan-cathedral.svg" alt="IMG"></i>
                        <div><b>Guidance of locals</b><span>Our drivers will take you to places, introduce traditions and give information of the place you are heading towards.</span></div>
                    </div>
                </div>
            </div>
        </div>
        <section class="b-video">
            <div class="container">
                <h2>VIDEO</h2>
            </div>
        </section>
        <div class="homehead__bottom">
            <div class="container">
                <div class="homehead__list">
                    <div class="homehead__list-item"><i>
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#luggage"></use>
                            </svg></i><b>Giving a hand with the luggage</b>
                        <p>Reservations may be achieved by just a single click. Due to our easily understandable system and structure of the website, your reservation will be completed in a few seconds. Free cancellation up to 24 hours before the journey. We understand that traveling always brings up unexpected changes.</p>
                    </div>
                    <div class="homehead__list-item"><i>
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#employees"></use>
                            </svg></i><b>Guidance of locals</b>
                        <p>Our drivers will take you to places, introduce traditions and give information of the place you are heading towards. Every driver, who is a member of mytripline company, is trained also as a guide and in that respect he is educated about each destination. Living in those regions, our drivers are mainly locals and know the most about their homes.</p>
                    </div>
                    <div class="homehead__list-item"><i>
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#driver"></use>
                            </svg></i><b>The driver becomes your personal guide</b>
                        <p>Every driver working for us speaks English fluently and endeavours to keep an eye on the most interesting spots passed along the journey.</p>
                    </div>
                </div>
                <div class="homehead__info"><em>Our motto says:</em>
                    <h3>«Every detail matters, although detail is just a word. We have given it true meaning»</h3>
                    <p>Every detail matter, even though detail is just a word. We have given it true meaning, “and in that respect each moment of your jouney and each day counts and makes difference when thought through in detail. Drivers aim to fulfil your full enjoyment of the experience.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="sliderhome">
        <div class="container">
            <div class="sliderhome__wrap">
                <h2 class="--fw-normal">We have nothing to lose and a world to see</h2>
                <div class="sliderhome-slider swiper-container">
                    <!-- Additional required wrapper-->
                    <div class="swiper-wrapper">
                        <!-- Slides-->
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                        <div class="swiper-slide"><i><img src="/img/sliderhome-1.jpg" alt="IMG"></i><b>Los Angeles</b>
                            <p>Pay full attention to the quality and cleanliness of our vehicles and driver selection, who will</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="b-efbooking">
        <div class="b-efbooking__wrap">
            <h2>Effective bookings</h2>
            <div class="b-efbooking__item"><i><img src="/img/touch-screen.svg" alt="IMG"></i>
                <div>
                    <h4>Reservations may be achieved by just a single click.</h4>
                    <p>Due to our easily understandable system and structure of the website, your reservation will be completed in a few seconds.</p>
                </div>
            </div>
            <div class="b-efbooking__item"><i><img src="/img/security.svg" alt="IMG"></i>
                <div>
                    <h6>Free cancellation up to 24 hours before the journey.</h6>
                    <p>We understand that travelling always brings up unexpected changes.</p>
                </div>
            </div>
        </div>
    </div>
    <section class="partners">
        <div class="container">
            <div class="partners__slider">
                <h2 class="--fw-400">Partners</h2>
                <div class="partners-slider swiper-container">
                    <!-- Additional required wrapper-->
                    <div class="swiper-wrapper">
                        <!-- Slides-->
                        @foreach($partners as $partner)
                            <div class="swiper-slide">
                                <img src="{{$partner['image']}}" alt="{{$partner['title']}}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="description">
        <div class="container">
            <div class="description__wrap">
                <div class="description__title">
                    <h2>Choose us</h2>
                </div>
                <div class="description__items">
                    <div class="description__item"><i><img src="/img/shield-svg.svg" alt="IMG"></i>
                        <div>
                            <h3>Safety.</h3>
                            <p>Each driver working for MYTRIPLINE has gone through the strict selection procedure. Speaking of our highest aim, getting your from A to B point while offering the greatest possible comfort meets up your and our desire. Time spent on getting to your final point does not have to be time wasted. With us it is simply enjoyable.</p>
                        </div>
                    </div>
                    <div class="description__item"><i><img src="/img/like-svg.svg" alt="IMG"></i>
                        <div>
                            <h3>Quality.</h3>
                            <p>To our precious clients, Mytripline guarantees every single ride to be a comfortable and delightful experience when facilitated through our company. In this respect, we pay full attention to the quality and cleanliness of our vehicles and driver selection, who will become your guide throughtout the journey.</p>
                        </div>
                    </div>
                    <div class="description__item"><i><img src="/img/lock-svg.svg" alt="IMG"></i>
                        <div>
                            <h3>Reliability.</h3>
                            <p>The journey always sets off on time. Our drivers will get you from A to B point while choosing the most comfortable route from multiple possibilities. This journey provided by our company also adds the best stops at must-see destinations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="countries">
        <div class="container">
            <div class="countries__wrap">
                <h2>Countries where we work</h2>
                <div class="countries__form">
                    <div class="form-block">
                        <div class="form-block__wrap">
                            <div class="label">One way</div>
                            <div class="form-vue countries-form calc" id="contry-form">
                                <form class="js-contry-form" data-submit="countriesFormSubmit">
                                    <v-select name="from"></v-select>
                                    <div class="date-time">
                                        <v-custom-calendar></v-custom-calendar>
                                        <v-time></v-time>
                                    </div>
                                    <v-humans></v-humans>
                                    <div class="label --white">Chauffeur will wait 15 minutes free of charge</div>
                                    <button class="btn-submit"><span>Search</span></button>
                                    <div class="form-vue__footer"><span>Can't find your destination?</span><a href="#">Request a custom route</a></div>
                                </form>
                            </div>
{{--                            <script>--}}
{{--                                function countriesFormSubmit(e) {--}}
{{--                                    console.log(e);--}}
{{--                                }--}}

{{--                            </script>--}}
                        </div>
                    </div>
                </div>
                <div class="countries__img"><img src="/img/svg/map.svg" alt="IMG"></div>
            </div>
        </div>
    </section>
@endsection
