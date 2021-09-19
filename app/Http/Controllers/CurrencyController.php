<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class CurrencyController extends Controller {

    public function switchCurrency( $code ) {
        if ( array_key_exists( $code, Config::get( 'app.currency_list' ) ) ) {
            Session::put( 'appcurrency', $code );
            return Redirect::to( Session::get( 'applocale' ) );
        }
        return Redirect::back();
    }

    public static function getCurrency(){
        return Session::get( 'appcurrency' ) ?? Config::get( 'app.currency' );
    }
}
