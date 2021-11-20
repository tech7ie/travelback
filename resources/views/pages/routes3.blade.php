@extends('layouts.app')

@section('content')
    <section class="routes3"
             style="background: url(/{{$route['image'] ?? 'url(../img/routes-bg3.jpg)'}})  top right no-repeat #202020;
                 background-position: center;">
        <div class="routes3__form">
            <div class="container">
                <div class="form-block">
                    <div class="form-block__wrap">
                        <div class="calc" id="routes3">
                            <form class="js-form-validator" action="/<?= app()->getLocale()?>/search">
                                <v-select routes="{{$routes ?? []}}"></v-select>
                                <div class="date-time">
                                    <v-custom-calendar></v-custom-calendar>
                                    <v-time></v-time>
                                </div>
                                <v-humans></v-humans>
                                <button class="btn-submit --simple"><span>{!! __("index.search") !!}</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="routes3__content">
            <div class="container">
                <div class="routes3__wrap">
                    <h1 class="routes3__title">{{$route['title'] ?? ''}}</h1>
                    <div class="routes3__grid">
                        <div class="routes3__item">
                            <svg class="icon">
                                <use xlink:href="{{asset('img/sprites/sprite.svg#pointer')}}"></use>
                            </svg>
                            {!! __("route.beginning") !!}
                        </div>
                        <div class="routes3__item">
                            <svg class="icon">
                                <use xlink:href="{{asset('img/sprites/sprite.svg#city')}}"></use>
                            </svg>
                            {!! __("route.extra_stops") !!}
                        </div>
                        <div class="routes3__item">
                            <svg class="icon">
                                <use xlink:href="{{asset('img/sprites/sprite.svg#baggage')}}"></use>
                            </svg>
                            {!! __("route.finish_ride") !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="routes3__img"><img src="{{asset('img/route2-img-2.jpg')}}" alt="IMG"></div>
    </section>
@endsection
