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
                                >{{substr(strip_tags($route['body']), 0, 420)}}
                                </div>
                            </div>
                            <div style="display: none;" id="hidden-content_{{$route['id']}}">
                                <h2>{{$route['title']}}</h2>
                                    <div>
                                        {{strip_tags($route['body'])}}
                                    </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
