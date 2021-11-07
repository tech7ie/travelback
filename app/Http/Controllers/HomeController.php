<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Routes;
use Illuminate\Http\Request;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('auth');
    }

    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $routes = Routes::select(
            [
                'id',
                'title',
                'route_from_city_id',
                'route_from_country_id',
                'route_to_city_id',
                'route_to_country_id',
                'price'
            ]
        )->where( 'status', '=', 'open' )
                        ->get();

        $result = [];
        foreach ( $routes as $route ) {
            $from_city    = $route->getFromCity();
            $from_country = $route->getFromCountry();
            $to_city      = $route->getToCity();
            $to_country   = $route->getToCountry();

            $points = [];
            foreach ( $route->pointsName() as $point ) {
                $points[] = $point->name;
            }

            $result[] =
                [
                    'id'                    => $route->id,
                    'title'                 => $route->title,
                    'from_city'             => $from_city[0]->name ?? '',
                    'route_from_city_id'    => $route->route_from_city_id,
                    'route_from_country_id' => $route->route_from_country_id,
                    'route_to_city_id'      => $route->route_to_city_id,
                    'route_to_country_id'   => $route->route_to_country_id,
                    'from_country'          => $from_country[0]->name ?? '',
                    'to_city'               => $to_city[0]->name ?? '',
                    'to_country'            => $to_country[0]->name ?? '',
                    'points'                => $points,
                ];
        }

        $partners = new PartnerController();

        $places = Place::query()->where('status', true)->limit(10)->get();


        $placesResponse = [];

        foreach ($places as $item){
            $placesResponse[] = [
                'id' => $item['id'],
                'title' => $this->getTranslateContent($item, 'title'),
                'body' => $this->getTranslateContent($item, 'body'),
                'image' => $item['image'],
                'durations' => $item['durations'],
                'extra_durations' => $item['extra_durations'],
            ];
        }

        return view( 'home', [
            'routes'   => json_encode($result),
            'partners' => $partners->list(),
            'places' => $placesResponse
        ] );
    }



    public function getTranslateContent($content, $key){
        return (isset($content[$key.'_'.app()->getLocale()]) && strlen($content[$key.'_'.app()->getLocale()]) > 0 ) ?$content[$key.'_'.app()->getLocale()] : $content[$key.'_en'];
    }
}
