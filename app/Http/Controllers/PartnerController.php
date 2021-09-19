<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller {

    /**
     * Show products list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index( \Illuminate\Http\Request $request ) {

        try {
            $routes = Partner::select( [ 'countries.name', 'countries.id' ] )->where( 'status', '=', 'open' )
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
     * @return array
     */
    public function list(): array {
        try {
            $partners = Partner::select( [ 'partners.*' ] )
                             ->where( 'status', '=', 'enabled' )
                            ->get()->toArray();
            return $partners;
        } catch ( \Throwable $t ) {
            return [$t->getMessage()];
        }
    }


}
