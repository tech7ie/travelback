<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller {

    /**
     * Show products list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index( \Illuminate\Http\Request $request ) {
        try {
            $data = $request->all();
//            $from_city_id = Cities::select( [ 'id' ] )->where( 'name', $data['from'] )->first();
//            $to_city_id   = Cities::select( [ 'id' ] )->where( 'name', $data['to'] )->first();
//
//            $where[] = [ 'status', 'open' ];
//
//            if ( $from_city_id ) {
//                $where[] = [ 'route_from_city_id', $from_city_id->id ];
//            }
//
//            if ( $to_city_id ) {
//                $where[] = [ 'route_from_city_id', $from_city_id->id ];
//            }


            $route = Routes::find($data['route'])
                            ->first();

            $places = $route->places;

            $cars = $route->cars;

            $from_city = $route->fromCity;
            $to_city = $route->toCity;

            return view( 'pages/search', [
                'currentRoute' => $route,
                'currentRoutePlaces' => $places,
                'debug'        => [ $data, $route, $places ]
            ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/search', [ 'currentRoute' => [], 'debug' => $t->getMessage() ] );
        }
    }
}
