<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Place;
use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Spatie\ImageOptimizer\OptimizerChainFactory;

// the image will be replaced with an optimized version which should be smaller

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


    public function getRoute( \Illuminate\Http\Request $request ) {
        try {
            $data  = $request->all();
            $route = Routes::find( $data['route'] );

            $places = $route->places;

            $placesResponse = [];

            foreach ( $places as $item ) {
                if ( $item['status'] === 'enabled' ) {
                    $placesResponse[] = [
                        'id'              => $item['id'],
                        'title'           => $this->getTranslateContent( $item, 'title' ),
                        'body'            => strip_tags( $this->getTranslateContent( $item, 'body' ) ),

                        //                        'body' => substr(strip_tags($this->getTranslateContent($item, 'body')),0, 320) . ((strlen(strip_tags($this->getTranslateContent($item, 'body'))) > 320) ? '...' : ''),
                        'image'           => $item['image'],
                        'price'           => $item['price'],
                        'durations'       => $item['durations'],
                        'extra_durations' => $item['extra_durations'],
                        'price_per_hour'  => $item['price_per_hour'],
                        'status'          => $item['status']
                    ];
                }
            }

            $cars = $route->cars;

            $from_city    = $route->fromCity;
            $from_country = $route->fromCountry;
            $to_city      = $route->toCity;

            return [
                'current_route'        => $route,
                'current_route_places' => $placesResponse
            ];

        } catch ( \Throwable $t ) {
            return [
                'current_route'        => [],
                'current_route_places' => []
            ];
        }
    }

    /**
     * routes list.
     *
     * @return array
     */
    public function routeList(): array {
        try {
            $routes = Routes::select(
                [
                    'id',
                    'title',
                    'route_from_city_id',
                    'route_from_country_id',
                    'route_to_city_id',
                    'route_to_country_id',
                    'route_start',
                    'route_end',
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
                        'route_start'           => $route->route_start,
                        'route_end'             => $route->route_end,
                    ];
            }

            return $result;
        } catch ( \Throwable $t ) {
            return [];
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

            foreach ( $routes as $route ) {
                $route->image = $this->getImageBySize('404x309',$route->image);
            }


            return view( 'pages/routes2', [ 'routes' => $routes, 'dd' => [ $id, $lang ] ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/routes2', [ 'routes' => [], 'dd' => [ $id, $lang ] ] );
        }
    }

    /**
     * Prepare cars list for request page.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function getCarsList() {
        try {
            $cars = Car::select()->get();

            return view( 'pages/request', [ 'cars' => $cars ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/request', [ 'cars' => [] ] );
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

        try {
            $route = Routes::select(
                [
                    'routes.*',
                ]
            )->where( 'status', '=', 'open' )
                           ->where( 'routes.id', $id )
                           ->first();
//            ImageOptimizer::optimize($route->image);

            $places = $route->places;

            $placesResponse = [];
            foreach ( $places as $item ) {
                $placesResponse[] = [
                    'id'              => $item['id'],
                    'title'           => $this->getTranslateContent( $item, 'title' ),
                    'body'            => strip_tags( $this->getTranslateContent( $item, 'body' ) ),
                    'image'           => $this->getImageBySize( '360x230', $item['image'] ),
                    'durations'       => $item['durations'],
                    'extra_durations' => $item['extra_durations'],
                    'price_per_hour'  => $item['price_per_hour'],
                ];
            }

            return view( 'pages/routes3', [
                'routes'          => json_encode( $result ),
                'route'           => $route,
                'places_response' => $placesResponse,
                'dd'              => [ $id, $lang ]
            ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/routes3', [ 'route' => [], 'dd' => [ $id, $lang ], 'error' => $t->getMessage() ] );
        }
    }

    /**
     * getAllRoutes list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getAllRoutes( \Illuminate\Http\Request $request ) {
        try {
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
                    if ( $point->status === 'enabled' ) {
                        $points[] = $point->name;
                    }
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

            return [ 'routes' => json_encode( $result ), ];

        } catch ( \Throwable $t ) {
            return [ 'error' => $t->getMessage() ];
        }
    }

    public function getTranslateContent( $content, $key ) {
        return ( isset( $content[ $key . '_' . app()->getLocale() ] ) && strlen( $content[ $key . '_' . app()->getLocale() ] ) > 0 ) ? $content[ $key . '_' . app()->getLocale() ] : $content[ $key . '_en' ];
    }


    public function getImageBySize($size, $image): string {
        try {
            $pathinfo = pathinfo($image);
            $pathinfo['basename'] = $size . '_' . $pathinfo['basename'];
            $resized_image = $pathinfo['dirname'] . '/' . $pathinfo['basename'];
        }catch (\Exception $e){
            return $image;
        }
        return $resized_image;
    }

}
