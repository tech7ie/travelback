@extends('layouts.app')

@section('content')
    <x-search
        :debug="$debug"
        :currentRoutePlaces="$currentRoutePlaces"
        :currentRoute="$currentRoute" />
@endsection
