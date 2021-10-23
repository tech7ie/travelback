<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteOrder extends Model
{
    use HasFactory;

    public function places()
    {
        return $this->morphToMany(Place::class, 'places_route_order')->withPivot(['price','durations']);
    }

    public function cars()
    {
        return $this->morphToMany(Car::class, 'cars_route_order')->withPivot('car_id');
    }

    public function getRoute()
    {
//        return Routes::find($this->route_id)->first();
        return Routes::find($this->route_id);
    }

//    public function getRoute()
//    {
////        return Routes::find($this->route_id)->first();
//        return PlacesRouteOrders::select()->where('route_id',);
//    }

    public function getCity($id)
    {
        return Cities::find($id);
    }

//    public function getFromCity()
//    {
//        return Cities::find($this->);
//    }
//
//    public function getToCity()
//    {
//        return Cities::find($this->);
//    }
}
