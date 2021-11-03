<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller {

    public function switchLang( $lang, Request $req ) {
        if ( array_key_exists( $lang, Config::get( 'languages' ) ) ) {
            Session::put( 'applocale', $lang );
            $path = $_GET['path'];
            $path = str_replace( '/' . app()->getLocale(), $lang, $path );

            return Redirect::to( $path );
        }

        return Redirect::back();
    }
}
