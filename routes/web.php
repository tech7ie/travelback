<?php

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

    Route::get( '/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

//    Route::get( '/', function () {
//        return view( 'home' );
//    } )->name('home');

//    Route::get( '/', function () {
//        return view( 'index' );
//    } );

    Route::get( '/about', [\App\Http\Controllers\PagePost::class, 'index'])->name('about');
    Route::get( '/terms-of-use', [\App\Http\Controllers\PagePost::class, 'index'])->name('terms-of-use');
    Route::get( '/privacy-policy', [\App\Http\Controllers\PagePost::class, 'index'])->name('privacy-policy');

    Auth::routes();

    Route::get( '/cabinet', function () {
        return view( 'pages/cabinet' );
    } )->name('cabinet');

    Route::get( '/order', function () {
        return view( 'pages/order' );
    } )->name('order');


    Route::get( '/order-success', function () {
        return view( 'pages/order-success' );
    } )->name('order-success');


    Route::get( '/request', function () {
        return view( 'pages/request' );
    } )->name('request');


    Route::get( '/search', function () {
        return view( 'pages/search' );
    } )->name('search');

    Route::get( '/routes', [\App\Http\Controllers\RoutesController::class, 'index'])->name('routes');
    Route::get( '/routes/{id?}', [\App\Http\Controllers\RoutesController::class, 'get'])->name('routesGet');
    Route::get( '/route_details/{id?}', [\App\Http\Controllers\RoutesController::class, 'details'])->name('routeDetails');

//    Route::get( '/routes', function () {
//        return view( 'pages/routes', ['one' => 1, 'two' => 2] );
//    } )->name('routes');

//TODO
    Route::get( '/routes2', function () {
        return view( 'pages/routes2' );
    } )->name('routes2');
//TODO
    Route::get( '/routes3', function () {
        return view( 'pages/routes3' );
    } )->name('routes3');


//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


} );
Route::fallback( function () {
    return view( 'pages/404' );
} );
//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
