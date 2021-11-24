@extends('layouts.app')

@section('content')
    <section class="page">
        <p>{!! $content['body'] ?? '' !!}</p>
    </section>
@endsection
