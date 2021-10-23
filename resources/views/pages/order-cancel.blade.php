@extends('layouts.app')

@section('content')
    <section class="order-error" style="display: block">
        <div class="order-success__wrap"><i>
                <svg class="icon">
                    <use xlink:href="/img/sprites/sprite.svg#emoji"></use>
                </svg>
            </i>
            <h2>Error in the<br>booking process</h2><em>Check the details and try again</em>
            <a class="btn" href="/{{app()->getLocale()}}">
                <svg class="icon">
                    <use xlink:href="/img/sprites/sprite.svg#refresh"></use>
                </svg>
                <span>Repeat</span></a>
        </div>
    </section>
@endsection
