@extends('layouts.app')

@section('content')
    <section class="routes">
        <div class="routes-header">
            <div class="container">
                <h2>{!! __("routes.routes") !!}</h2><span>{!! __("routes.select_a_country") !!}</span>
            </div>
        </div>
        <div class="routes-content container">
            @foreach($routes->chunk(18) as $three)
                <ul>
                    @foreach($three as $country)
                        <li><a href="{{ route('routes', app()->getLocale()) . '/' . $country['id'] }}">{{ $country['name'] }}</a></li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </section>
@endsection
