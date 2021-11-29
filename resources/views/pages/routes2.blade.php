@extends('layouts.app')
@section('content')
    <div class="roites2">
        <div class="container">
            <div class="routes2__wrap">
                <h2>{!! __("routes2.select_a_country") !!}</h2>
                <div class="routes2__grid">
                    @foreach($routes as $route)
                        <a class="routes2__item"
                           href="{{ route('routeDetails', app()->getLocale()) . '/' . $route['id'] }}"
                           style="background-image: url({{asset($route['image'])}})">
                            <div class="wrap-text">
                                <h4>{{$route['title']}}</h4>
                                <div
                                    data-fancybox data-src="#hidden-content_{{$route['id']}}"
                                >{!! $route['body'] !!}</div>
                            </div>
                            <div style="display: none;" id="hidden-content_{{$route['id']}}">
                                <h2>{{$route['title']}}</h2>
                                <p>
                                    {!! $route['body'] !!}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
