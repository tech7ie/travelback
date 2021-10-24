@extends('layouts.app')

@section('content')
    <section class="order-success">
        <div class="order-success__wrap"><i>
                <svg class="icon">
                    <use xlink:href="/img/sprites/sprite.svg#check"></use>
                </svg>
            </i>
            <h2>Thank you for booking!</h2><em>Your login details have been sent to the mail</em>
            <h2>Cash payment instructions</h2>

            <a class="btn" href="/{{app()->getLocale()}}">
                <svg class="icon">
                    <use xlink:href="/img/sprites/sprite.svg#arrow"></use>
                </svg>
                <span>Go home</span></a>
        </div>
    </section>
@endsection
