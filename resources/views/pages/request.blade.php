@extends('layouts.app')

@section('content')
    <div class="request" style="background-image: url({{asset('/img/request-bg.jpg')}})">
        <div class="container">
            <div class="request__wrap">
                <div class="form-block">
                    <h2>Enjoy your trip</h2>
                    <div class="form-block__wrap">
                        <div class="label">One way</div>
                        <v-calculator></v-calculator>
                    </div>
                </div>
                <div class="request__info">
                    <div class="request__info-item"><i>
                            <!--img(src="/img/map.svg" alt="IMG")-->
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#map2"></use>
                            </svg></i>
                        <div><b>From A to B service</b><span>Get easily from your starting to<br>the final spot.</span></div>
                    </div>
                    <div class="request__info-item"><i>
                            <!--img(src="/img/map.svg" alt="IMG")-->
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#messenger"></use>
                            </svg></i>
                        <div><b>We’ll send you a quote</b><span>Provided information will<br>be processed and we will reach you<br>with an offer in the shortest time<br>possible.</span></div>
                    </div>
                    <div class="request__info-item"><i>
                            <!--img(src="/img/map.svg" alt="IMG")-->
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#check-mark"></use>
                            </svg></i>
                        <div><b>Confirm</b><span>We will send you an affirmation<br>of a journey and everything<br>essential by email.</span></div>
                    </div>
                    <div class="request__info-item"><i>
                            <!--img(src="/img/milan-cathedral.svg" alt="IMG")-->
                            <svg class="icon">
                                <use xlink:href="/img/sprites/sprite.svg#milan-cathedral"></use>
                            </svg></i>
                        <div><b>Guidance of locals</b><span>Our drivers will take you to places,<br>introduce traditions and give<br>information of the place<br>you are heading towards.</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
