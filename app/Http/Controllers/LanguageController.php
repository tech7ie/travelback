<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller {

    public function switchLang( $lang, Request $req ) {

        if ( array_key_exists( $lang, Config::get( 'languages' ) ) ) {

            $path = $_GET['path'];

            if (strlen($path) === 3){
                $path = '/' . $lang;
            }else{
                $path = str_replace( substr($path,0,3), $lang, $path );

            }
            Session::put( 'applocale', $lang );
            app()->setLocale($lang);


            return Redirect::to( $path );
        }

        return Redirect::back();
    }
}
