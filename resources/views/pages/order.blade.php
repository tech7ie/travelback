@extends('layouts.app')

@section('content')
    <script src="https://js.stripe.com/v3/"></script>

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

    <script>
        $(document).ready(function($){

            $j=jQuery.noConflict();
            /*
            * International Telephone Input v16.0.0
            * https://github.com/jackocnr/intl-tel-input.git
            * Licensed under the MIT license
            */
            var input = document.querySelectorAll("input[name=phone]");
            var iti_el = $('.iti.iti--allow-dropdown.iti--separate-dial-code');
            if (iti_el.length) {
                iti.destroy();

                // Get the current number in the given format
            }
            for (var i = 0; i < input.length; i++) {
                iti = intlTelInput(input[i], {
                    autoHideDialCode: false,
                    autoPlaceholder: "aggressive",
                    initialCountry: "us",
                    separateDialCode: true,
                    preferredCountries: ['ru', 'th'],
                    customPlaceholder: function (selectedCountryPlaceholder, selectedCountryData) {
                        var phone = $('input[name="phone"]').val()
                        var placeholder = '' + selectedCountryPlaceholder.replace(/[0-9]/g, 'X');
                        $('input[name="phone"]').data('placeholder', placeholder)
                        return !phone ? 'Phone number' : placeholder
                    },
                    geoIpLookup: function (callback) {
                        $.get('https://ipinfo.io', function () {
                        }, "jsonp").always(function (resp) {
                            var countryCode = (resp && resp.country) ? resp.country : "";
                            callback(countryCode);
                        });
                    },
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js" // just for
                });

                $('input[name="phone"]').on("focus click countrychange", function (e, countryData) {
                    var pl = $(this).data('placeholder') + '';
                    var res = pl.replace(/X/g, '9');
                    if (res !== 'undefined') {
                        console.log($(this));
                        $(this).inputmask(res, {placeholder: "X", clearMaskOnLostFocus: true});
                    }


                });
                console.log(333)
                $('input[name="phone"]').on("focusout", function (e, countryData) {
                    var intlNumber = iti.getNumber();
                });

            }
        })
    </script>
@endsection
