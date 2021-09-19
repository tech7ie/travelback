<?php

namespace App\Http\Controllers;

use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutesController extends Controller {

    /**
     * Show products list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index( \Illuminate\Http\Request $request ) {

        try {
            $routes = Routes::select( [ 'countries.name', 'countries.id' ] )->where( 'status', '=', 'open' )
                            ->join( 'countries', 'countries.id', '=', 'routes.route_to_country_id' )
                            ->groupBy( 'countries.id' )
                            ->get();
            return view( 'pages/routes', [ 'routes' => $routes ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/routes', [ 'routes' => [], 'error' => $t->getMessage() ] );
        }
    }


    /**
     * Show products list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function router( \Illuminate\Http\Request $request ) {
        try {
            $routes = Routes::select( [ 'cities.name', 'cities.id' ] )->where( 'status', '=', 'open' )
                            ->join( 'cities_routes', 'cities_routes.cities_route_id', '=', 'routes.id' )
                            ->join( 'cities', 'cities.id', '=', 'cities_routes.cities_id' )
                            ->get();

//            $routes = Routes::select()->get();
            return view( 'pages/routes', [ 'routes' => $routes ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/routes', [ 'routes' => [ 's' ] ] );
        }
    }


    /**
     * Show products list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function get( $lang, $id ) {
        try {
            $routes = Routes::select(
                [
                    'routes.*',
                ]
            )->where( 'status', '=', 'open' )
                            ->where( 'routes.route_to_country_id', $id )
                            ->get();

            return view( 'pages/routes2', [ 'routes' => $routes, 'dd' => [$id, $lang] ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/routes2', [ 'routes' => [], 'dd' => [$id, $lang] ] );
        }
    }


    /**
     * Show products list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function details( $lang, $id ) {
        try {
            $routes = Routes::select(
                [
                    'routes.*',
                ]
            )->where( 'status', '=', 'open' )
                            ->where( 'routes.id', $id )
                            ->get();

            return view( 'pages/routes3', [ 'routes' => $routes, 'dd' => [$id, $lang] ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/routes3', [ 'routes' => [], 'dd' => [$id, $lang] ] );
        }
    }
}
