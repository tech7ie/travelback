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

Route::get('setlocale/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Route::get('/', function () {
    echo 'ddd';
    return redirect(app()->getLocale());
});

Route::group(['prefix' => '{lang}', 'where' => ['lang' => '[a-zA-Z]{2}'], 'middleware' => 'languageSwitcher'], function() {

    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
