<?php

namespace App\Http\Controllers;

use App\Models\CarRoute;
use App\Models\CarsRouteOrders;
use App\Models\PlacesRouteOrders;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class RouteOrder extends Controller {
    //

    /**
     * Save order.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function save( \Illuminate\Http\Request $request ) {

        try {


            $data = $request->all();


            $d = '{
            "route_id":1,
            "route_date":"2021.10.24 02:44:00",
            "total":"283.00",
            "adults":"1",
            "childrens":"0",
            "luggage":"1",
            "cars":[{"id":1,"count":1,"price":250}]
            ,"places":[{"id":3,"duration":null,"price":"33.00"}],"user_id":1}';

            $data['user_id'] = \Auth::user()->id ?? 1;


            $routeOrder = new \App\Models\RouteOrder();


            $routeOrder->user_id          = $data['user_id'] ?? 0;
            $routeOrder->email            = $data['order_details']['email'] ?? '';
            $routeOrder->first_name       = $data['order_details']['first_name'] ?? '';
            $routeOrder->last_name        = $data['order_details']['last_name'] ?? '';
            $routeOrder->phone            = $data['order_details']['phone'] ?? '';
            $routeOrder->comment          = $data['order_details']['comment'] ?? '';
            $routeOrder->pickup_address   = $data['order_details']['pickup_address'] ?? '';
            $routeOrder->drop_off_address = $data['order_details']['drop_off_address'] ?? '';
            $routeOrder->currency         = $data['currency'] ?? 'eur';
            $routeOrder->route_id         = $data['route_id'];
            $routeOrder->route_date       = $data['route_date'];
            $routeOrder->amount           = $data['total'];
            $routeOrder->adults           = $data['adults'];
            $routeOrder->childrens        = $data['childrens'];
            $routeOrder->luggage          = $data['luggage'];
            $routeOrder->save();

            foreach ( $data['cars'] as $c ) {
                $car = new CarsRouteOrders();

                $car->cars_route_order_id = $routeOrder->id;
                $car->car_id              = $c['id'];
                $car->count               = $c['count'];
                $car->price               = $c['price'];

                $car->save();
            }

            foreach ( $data['places'] as $p ) {
                $place = new PlacesRouteOrders();

                $place->places_route_order_id = $routeOrder->id;
                $place->place_id              = $p['id'];
                $place->durations             = $p['duration'];
                $place->price                 = $p['price'];

                $place->save();

            }


            if ( isset( $data['payment_type'] ) && $data['payment_type'] === 1 ) {
                $stripe = new \Stripe\StripeClient( env( 'STRIPE_SECRET_API' ) );

                $token = $data['stripe_token'];

                $charge = $stripe->charges->create( [
                    'amount'      => (int) $routeOrder->amount * 100,
                    'currency'    => 'usd',
                    'description' => 'Example charge',
                    'source'      => $token,
                    'metadata'    => [ 'order_id' => $routeOrder->id ]
                ] );


                if ( $charge['status'] && $charge['status'] === 'succeeded' ) {
                    $routeOrder->status = 'complete';
                    $routeOrder->save();
                } else {
                    $routeOrder->status = 'fail';
                    $routeOrder->save();
                }

//            return $charge;

            }

            return true;

        } catch ( \Throwable $e ) {
            print_r($e);
            return $e->getMessage();
        }
//        return $data;
    }

    function generateResponse( $intent ) {
        # Note that if your API version is before 2019-02-11, 'requires_action'
        # appears as 'requires_source_action'.
        if ( $intent->status == 'requires_action' &&
             $intent->next_action->type == 'use_stripe_sdk' ) {
            # Tell the client to handle the action
            echo json_encode( [
                'requires_action'              => true,
                'payment_intent_client_secret' => $intent->client_secret
            ] );
        } else if ( $intent->status == 'succeeded' ) {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            echo json_encode( [
                "success" => true
            ] );
        } else {
            # Invalid status
            http_response_code( 500 );
            echo json_encode( [ 'error' => 'Invalid PaymentIntent status' ] );
        }
    }
}
