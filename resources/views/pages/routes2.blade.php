@extends('layouts.app')
@section('content')
    <div class="roites2">
        <div class="container">
            <div class="routes2__wrap">
                <h2>Select a routes</h2>
                <div class="routes2__grid">
                    @foreach($routes as $route)
                                <a class="routes2__item"
                                   href="{{ route('routeDetails', app()->getLocale()) . '/' . $route['id'] }}"
                                   style="background-image: url({{asset($route['image'])}})">
                                    <h4>{{$route['title']}}</h4>
                                    <p>{!! $route['body'] !!}</p>
                                </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
