<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Place;
use App\Models\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

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
            $data  = $request->all();
            $route = Routes::find( $data['route'] );

            $places = $route->places;

            $placesResponse = [];

            foreach ( $places as $item ) {
                if ( $item['status'] === 'enabled' ) {
                    $placesResponse[] = [
                        'id'              => $item['id'],
                        'title'           => $this->getTranslateContent( $item, 'title' ),
                        'body' => substr(strip_tags($this->getTranslateContent($item, 'body')),0, 220) . ((strlen(strip_tags($this->getTranslateContent($item, 'body'))) > 220) ? '...' : ''),
                        'image'           => $item['image'],
                        'price'           => $item['price'],
                        'durations'       => $item['durations'],
                        'extra_durations' => $item['extra_durations'],
                        'status'          => $item['status']
                    ];
                }
            }

            $cars = $route->cars;

            $from_city    = $route->fromCity;
            $from_country = $route->fromCountry;
            $to_city      = $route->toCity;

            return view( 'pages/search', [
                'currentRoute'       => $route,
                'currentRoutePlaces' => $placesResponse,
                'debug'              => [ 'data' => $data, 'route' => $route, 'places' => $placesResponse ]
            ] );

        } catch ( \Throwable $t ) {
            return view( 'pages/search', [ 'currentRoute' => [], 'debug' => $t->getMessage() ] );
        }
    }

    /**
     * getRoutePlaces list.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getRoutePlaces( \Illuminate\Http\Request $request ) {
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
                        'body' => substr(strip_tags($this->getTranslateContent($item, 'body')),0, 150) . ((strlen(strip_tags($this->getTranslateContent($item, 'body'))) > 150) ? '...' : ''),
                        'image'           => $item['image'],
                        'durations'       => $item['durations'],
                        'extra_durations' => $item['extra_durations'],
                        'status'          => $item['status']
                    ];
                }
            }

            return $placesResponse;

        } catch ( \Throwable $t ) {
            return [ 'dd' => $t->getMessage() ];
        }
    }


    public function setRequest( \Illuminate\Http\Request $request ) {
//        $to_email = 'bogbuk@gmail.com';
        $to_email = 'route@mytripline.com';

        $data_send = $request->all();

        unset( $data_send['route'] );
        unset( $data_send['pm'] );
        unset( $data_send['am'] );

        try {
            Mail::send( 'emails.request', [ 'data_send' => $data_send ], function ( $message ) use (
                $to_email
            ) {
                $message->to( $to_email )
                        ->subject( 'TripLine Request' );
            } );

            return true;
        } catch ( Exception $e ) {
            return $e->getMessage();
        }
    }


    public function getTranslateContent( $content, $key ) {
        return ( isset( $content[ $key . '_' . app()->getLocale() ] ) && strlen( $content[ $key . '_' . app()->getLocale() ] ) > 0 ) ? $content[ $key . '_' . app()->getLocale() ] : $content[ $key . '_en' ];
    }
}
