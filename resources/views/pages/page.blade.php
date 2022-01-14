@extends('layouts.app')

@section('content')
    <section class="page">
        <div class="container">
            <p>{!! $content['body'] ?? '' !!}</p>
        </div>
    </section>
@endsection
