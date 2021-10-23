<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('setlocale/{locale}',function($lang){
//    \Session::put('locale',$lang);
//    return redirect()->back();
//});

Route::get( 'setlocale/{lang}', [
    'as'   => 'lang.switch',
    'uses' => 'App\Http\Controllers\LanguageController@switchLang'
] );


Route::get( 'setcurrency/{code}', [
    'as'   => 'currency.switch',
    'uses' => 'App\Http\Controllers\CurrencyController@switchCurrency'
] );

Route::get( '/', function () {
    return redirect( app()->getLocale() );
} );

Route::group( [
    'prefix'     => '{lang}',
    'where'      => [ 'lang' => '[a-zA-Z]{2}' ],
    'middleware' => 'languageSwitcher'
], function () {

    Route::get( '/', [ \App\Http\Controllers\HomeController::class, 'index' ] )->name( 'home' );

//    Route::get( '/', function () {
//        return view( 'home' );
//    } )->name('home');

//    Route::get( '/', function () {
//        return view( 'index' );
//    } );

    Route::get( '/about', [ \App\Http\Controllers\PagePost::class, 'about' ] )->name( 'about' );
    Route::get( '/terms-of-use', [ \App\Http\Controllers\PagePost::class, 'index' ] )->name( 'terms-of-use' );
    Route::get( '/privacy-policy', [ \App\Http\Controllers\PagePost::class, 'index' ] )->name( 'privacy-policy' );


    Route::post( '/cabinet', [ \App\Http\Controllers\UserController::class, 'update' ] )->name( 'edit_profile' );



    Route::post( '/set_order', [ \App\Http\Controllers\RouteOrder::class, 'save' ])->name( 'save_order' );



    Auth::routes();
    Route::get( '/cabinet', [ \App\Http\Controllers\UserController::class, 'cabinet' ])->name( 'cabinet' );

    Route::get( '/order', function () {
        return view( 'pages/order', [
            'payments_methods' => [
                [
                    "title" => "Apple Pay",
                    "code"  => 'apple-pay',
                    "img"   => '/img/apple-pay.svg',
                ],
                [
                    "title" => "Visa",
                    "code"  => 'visa',
                    "img"   => '/img/visa.svg',
                ],
                [
                    "title" => "Mastercard",
                    "code"  => 'mastercard',
                    "img"   => '/img/mastercard.svg',
                ],
                [
                    "title" => "Maestro",
                    "code"  => 'maestro',
                    "img"   => '/img/maestro.svg',
                ],
                [
                    "title" => "American Express",
                    "code"  => 'american-express',
                    "img"   => '/img/american-express.svg',
                ],
                [
                    "title" => "Google Pay",
                    "code"  => 'google-pay',
                    "img"   => '/img/google-pay.svg',
                ],
                [
                    "title" => "Alipay",
                    "code"  => 'alipay',
                    "img"   => '/img/alipay.svg',
                ],
            ]
        ] );
    } )->name( 'order' );

//
//    Route::post( '/order', [ \App\Http\Controllers\RouteOrder::class, 'save' ])->name( 'save_order' );
//

    Route::get( '/order-success', function () {
        return view( 'pages/order-success' );
    } )->name( 'order-success' );



    Route::get( '/order-cancel', function () {
        return view( 'pages/order-cancel' );
    } )->name( 'order-cancel' );


    Route::get( '/request', function () {
        return view( 'pages/request' );
    } )->name( 'request' );


    Route::get( '/search', [ \App\Http\Controllers\SearchController::class, 'index' ] )->name( 'search' );

//    Route::get( '/search', function () {
//        return view( 'pages/search' );
//    } )->name('search');

    Route::get( '/routes', [ \App\Http\Controllers\RoutesController::class, 'index' ] )->name( 'routes' );
    Route::get( '/routes/{id?}', [ \App\Http\Controllers\RoutesController::class, 'get' ] )->name( 'routesGet' );
    Route::get( '/route_details/{id?}', [ \App\Http\Controllers\RoutesController::class, 'details' ] )
         ->name( 'routeDetails' );

//    Route::get( '/routes', function () {
//        return view( 'pages/routes', ['one' => 1, 'two' => 2] );
//    } )->name('routes');

//TODO
    Route::get( '/routes2', function () {
        return view( 'pages/routes2' );
    } )->name( 'routes2' );
//TODO
    Route::get( '/routes3', function () {
        return view( 'pages/routes3' );
    } )->name( 'routes3' );


//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


} );
Route::fallback( function () {
    return view( 'pages/404' );
} );
//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
