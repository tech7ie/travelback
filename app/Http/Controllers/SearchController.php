<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Place;
use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller {

    /**
     * Show route by ID.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index( \Illuminate\Http\Request $request ) {
        try {
            $data = $request->all();
            $route = Routes::find($data['route']);

            $places = $route->places;

            $cars = $route->cars;

            $from_city = $route->fromCity;
            $from_country = $route->fromCountry;
            $to_city = $route->toCity;

            return view( 'pages/search', [
                'currentRoute' => $route,
                'currentRoutePlaces' => $places,
                'debug'        => [ 'data' => $data, 'route'=>$route, 'places' => $places ]
            ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/search', [ 'currentRoute' => [], 'debug' => $t->getMessage() ] );
        }
    }
    /**
     * Show products list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getRoutePlaces( \Illuminate\Http\Request $request ) {
        try {
            $data = $request->all();
            $route = Routes::find($data['route']);

            $places = $route->places;

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

            return $placesResponse;

        } catch ( \Throwable $t ) {
            return ['dd' => $t->getMessage()];
        }
    }


    public function getTranslateContent($content, $key){
        return (isset($content[$key.'_'.app()->getLocale()]) && strlen($content[$key.'_'.app()->getLocale()]) > 0 ) ?$content[$key.'_'.app()->getLocale()] : $content[$key.'_en'];
    }
}
