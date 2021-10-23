@extends('layouts.app')

@section('content')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.css" rel="stylesheet">
    <div class="header-block --border" style="background-image: url({{asset('img/order-bg.jpg')}});">
        <div class="container">
            <div class="header-block__wrap">
                <h1>Complete your booking</h1>
            </div>
        </div>
    </div>
    <v-order-route :payment_methods="{{@\GuzzleHttp\json_encode($payments_methods)}}"
                   csrf="{{csrf_token()}}"
    ></v-order-route>
@endsection
