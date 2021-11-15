<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/get_route_places', [ \App\Http\Controllers\SearchController::class, 'getRoutePlaces' ]);


Route::post('/get_all_routes', [ \App\Http\Controllers\RoutesController::class, 'getAllRoutes' ]);


Route::post('/get_route', [ \App\Http\Controllers\RoutesController::class, 'getRoute' ]);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


