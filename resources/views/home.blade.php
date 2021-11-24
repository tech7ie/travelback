@extends('layouts.app')

@section('content')
    <div class="homehead">
        <div class="homehead__top">
            <div class="container">
                <div class="homehead__wrap">
                    <div class="homehead__form">
                        <div class="form-block">
                            <div class="form-block__wrap">
                                <div class="label">@lang('widgets.calculator.title')</div>
                                <div class="homehead-form form-vue calc" id="homehead-form">
                                    <v-calculator :request="{{json_encode($_GET)}}" :short="true" mode="home" routes="{{$routes ?? []}}">
                                    </v-calculator>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="homehead__content">
                        <h1>{!! __("home.home_title") !!}</h1>
{{--                        <div class="homehead__content-label"><i><img src="/img/logo-min.svg" alt="IMG"></i>--}}
{{--                            <div>{!! __("home.home_sub_title") !!}</div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="homehead-info">
            <div class="container">
                <div class="homehead-info__grid">
                    <div class="homehead-info__item"><i><img src="/img/map.svg" alt="IMG"></i>
                        <div>
                            {!! __("home.block_1.1") !!}
                        </div>
                    </div>
                    <div class="homehead-info__item"><i><img src="/img/milan-cathedral.svg" alt="IMG"></i>
                        <div>
                            {!! __("home.block_1.2") !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="b-video"
                 data-fancybox="" data-src="{{$content['embed_video'] ?? 'https://www.youtube.com/watch?v=NpEaa2P7qZI'}}"
                 style="cursor:pointer; background: url({{ strlen($content['block_image']) > 0  ? $content['block_image'] : '../img/video-bg.jpg'}}) center center no-repeat; background-size: cover;
                     }">
            <div class="container">
                <h2>{!! $content['video_block_title'] ?? '' !!}</h2>
            </div>
        </section>
        <div class="homehead__bottom">
            <div class="container">
                <div class="homehead__list">
                    <div class="homehead__list-item"><i>
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#luggage"></use>
                            </svg>
                        </i>

                        {!! __("home.block_2.1") !!}

                    </div>
                    <div class="homehead__list-item"><i>
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#employees"></use>
                            </svg>
                        </i>
                        {!! __("home.block_2.2") !!}
                    </div>
                    <div class="homehead__list-item"><i>
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#driver"></use>
                            </svg>
                        </i>
                        {!! __("home.block_2.3") !!}
                    </div>
                </div>
                <div class="homehead__info">
                    {!! __("home.block_3.1") !!}
                </div>
            </div>
        </div>
    </div>
    <div class="sliderhome-desktop-mob">
        <div class="sliderhome">
            <div class="sliderhome__wrap">
                <div class="container">
                    <h2 class="--fw-normal">{!! __("home.block_places_slider") !!}</h2>
                </div>
                <div class="sliderhome-slider swiper-container">
                    <!-- Additional required wrapper-->
                    <div class="swiper-wrapper">
                        <!-- Slides-->
                        @foreach($places as $item)
                            <div class="swiper-slide"><i><img src="{{$item['image']}}" alt="IMG"></i>
                                <b>{{$item['title']}}</b>
                                <div class="swipe_body" style="max-height: 190px">
                                    {!! $item['body'] !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="b-efbooking">
        <div class="b-efbooking__wrap">
            <div class="b-efbooking__bg">
                <h2>{!! __("home.block_4.title") !!}</h2>
                <div class="b-efbooking__item">
                    <i>
                        <img src="/img/touch-screen.svg" alt="touch-screen">
                    </i>
                    <div>{!! __("home.block_4.1") !!}</div>
                </div>
                <div class="b-efbooking__item">
                    <i>
                        <img src="/img/security.svg" alt="security">
                    </i>
                    <div>{!! __("home.block_4.2") !!}</div>
                </div>
            </div>
        </div>
    </div>
    @if($partners && count($partners) > 0)
        <section class="partners">
            <div class="container">
                <div class="partners__slider">
                    <h2 class="--fw-400">{!! __("home.block_partners_slider") !!}</h2>
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
    @endif
    <section class="description">
        <div class="container">
            <div class="description__wrap">
                <div class="description__title">
                    <h2>{!! __("home.block_5.title") !!}</h2>
                </div>
                <div class="description__items">
                    <div class="description__item"><i><img src="/img/shield-svg.svg" alt="IMG"></i>
                        <div>{!! __("home.block_5.1") !!}</div>
                    </div>
                    <div class="description__item"><i><img src="/img/like-svg.svg" alt="IMG"></i>
                        <div>{!! __("home.block_5.2") !!}</div>
                    </div>
                    <div class="description__item"><i><img src="/img/lock-svg.svg" alt="IMG"></i>
                        <div>{!! __("home.block_5.3") !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="countries">
        <div class="container">
            <div class="countries__wrap">
                <h2>{!! __("home.block_6.title") !!}</h2>
                <div class="countries__form">
                    <div class="form-block">
                        <div class="form-block__wrap">
                            <div class="label">{!! __("widgets.calculator.title") !!}</div>
                            <div class="homehead-form form-vue calc" id="homehead-form">
                                <v-calculator :request="{{json_encode($_GET)}}" :short="true" routes="{{$routes ?? []}}">

                                </v-calculator>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="countries__img">
                    <img class="desktop" src="/img/map-color.svg" alt="desktop_map">
                    <img class="mobile" src="/img/svg/map-2.svg" alt="mobile_map">
                </div>
            </div>
        </div>
    </section>
@endsection
