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
//            Validator::make( $request->all(), [
////            'email'   => [ 'email' ],
////            'name'    => [ 'required' ],
////            'phone'   => [ 'required' ],
//'company'    => [ 'required' ],
//'company.id' => [ 'required' ],
//            ] )->validate();


            $data = $request->all();
//            $data['user_id'] = Auth::user()->id;

            $from_city_id = Cities::select( [ 'id' ] )->where( 'name', $data['from'] )->first();
            $to_city_id   = Cities::select( [ 'id' ] )->where( 'name', $data['to'] )->first();

            $where[] = [ 'status', 'open' ];

//            foreach ( $data as $key => $value ) {
//                $where[] = [ $key, $value ];
//            }

            if ( $from_city_id ) {
                $where[] = [ 'route_from_city_id', $from_city_id->id ];
            }

            if ( $to_city_id ) {
                $where[] = [ 'route_from_city_id', $from_city_id->id ];
            }


            $route = Routes::select()->where( $where )
                            ->first();

            $places = $route->places;

            return view( 'pages/search', [
                'currentRoute' => $route,
                'currentRoutePlaces' => $places,
                'debug'        => [ $data, $route, $places, $from_city_id, $to_city_id ]
            ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/search', [ 'currentRoute' => [], 'debug' => $t->getMessage() ] );
        }
    }
}
