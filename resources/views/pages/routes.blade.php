@extends('layouts.app')

@section('content')
    <section class="routes">
        <div class="routes-header">
            <div class="container">
                <h2>Routes</h2><span>Select a country</span>
            </div>
        </div>
        <div class="routes-content container">
            {{$error ?? ''}}
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
