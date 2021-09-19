<?php

namespace App\Http\Controllers;

use App\Models\Routes;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $routes = Routes::select(['cities.name','cities.id'])->where('status', '=', 'open')
                        ->join('cities_routes', 'cities_routes.cities_route_id', '=', 'routes.id')
                        ->join('cities', 'cities.id', '=', 'cities_routes.cities_id')
                        ->get();

        $partners = new PartnerController();
        return view('home', [
            'routes' => $routes,
            'partners' => $partners->list()
        ]);
    }
}
