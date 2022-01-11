@extends('layouts.app')

@section('content')
    <section class="page">
        <div class="container">
            <h2 style="padding-top: 20px; text-align: center">{!! $content['title'] ?? '' !!}</h2>
            <p>{!! $content['body'] ?? '' !!}</p>
        </div>
    </section>
@endsection
