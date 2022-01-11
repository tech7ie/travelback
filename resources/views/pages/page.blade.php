@extends('layouts.app')

@section('content')
    <section class="page">
        <div class="container">
            <р2 style="padding-top: 20px">{!! $content['title'] ?? '' !!}</р2>
            <p>{!! $content['body'] ?? '' !!}</p>
        </div>
    </section>
@endsection
