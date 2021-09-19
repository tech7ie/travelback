@extends('layouts.app')

@section('content')
    <section class="page">
        {!! $content['body'] ?? '' !!}
    </section>
@endsection
