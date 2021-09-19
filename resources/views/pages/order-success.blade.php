@extends('layouts.app')

@section('content')
    <section class="order-success">
        <div class="order-success__wrap"><i>
                <svg class="icon">
                    <use xlink:href="img/sprites/sprite.svg#check"></use>
                </svg></i>
            <h2>Thank you for booking!</h2><em>Your login details have been sent to the mail</em><a class="btn">
                <svg class="icon">
                    <use xlink:href="img/sprites/sprite.svg#arrow"></use>
                </svg><span>Go home</span></a>
        </div>
    </section>
    <section class="order-error">
        <div class="order-success__wrap"><i>
                <svg class="icon">
                    <use xlink:href="img/sprites/sprite.svg#emoji"></use>
                </svg></i>
            <h2>Error in the<br>booking process</h2><em>Check the details and try again</em><a class="btn">
                <svg class="icon">
                    <use xlink:href="img/sprites/sprite.svg#refresh"></use>
                </svg><span>Repeat</span></a>
        </div>
    </section>
@endsection
