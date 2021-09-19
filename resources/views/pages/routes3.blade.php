@extends('layouts.app')

@section('content')
    <section class="routes3">
        <div class="routes3__form">
            <div class="container">
                <div class="form-block">
                    <div class="form-block__wrap">
                        <div class="calc" id="routes3">
                            <form class="js-form-validator">
                                <v-select></v-select>
                                <div class="date-time">
                                    <v-custom-calendar></v-custom-calendar>
                                    <v-time></v-time>
                                </div>
                                <v-humans></v-humans>
                                <button class="btn-submit --simple"><span>Search</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="routes3__content">
            <div class="container">
                <h1>Eiffel Tower</h1>
                <div class="routes3__grid">
                    <div class="routes3__item">
                        <svg class="icon">
                            <use xlink:href="{{asset('img/sprites/sprite.svg#pointer')}}"></use>
                        </svg><b>Beginning</b><span>Your driver will arrive at the starting point</span>
                    </div>
                    <div class="routes3__item">
                        <svg class="icon">
                            <use xlink:href="{{asset('img/sprites/sprite.svg#city')}}"></use>
                        </svg><b>Extra stops</b><span>During the ride, you will stop to sightsee a city</span>
                    </div>
                    <div class="routes3__item">
                        <svg class="icon">
                            <use xlink:href="{{asset('img/sprites/sprite.svg#baggage')}}"></use>
                        </svg><b>Finish ride</b><span>Completing the ride with your driver who will help with your baggage up to a hotel/boat/airport</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="routes3__img"><img src="{{asset('img/route2-img-2.jpg')}}" alt="IMG"></div>
    </section>
@endsection
