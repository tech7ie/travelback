<?php

namespace App\Models;

use App\Models\Cities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class Routes extends Model
{
    use HasFactory;

    public function cars()
    {
        return $this->belongsToMany(Car::class);
    }

    public function points()
    {
        return $this->morphToMany(Cities::class, 'cities_route');
    }


    public function places()
    {
        return $this->morphToMany(Place::class, 'places_route');
    }

    public function pointsName(): \Illuminate\Database\Eloquent\Collection {
        return $this->morphToMany(Cities::class, 'cities_route')->select(['name'])->get();
    }

    public function getFromCity(): \Illuminate\Database\Eloquent\Collection {
        return
            $this->hasOne(Cities::class,'id','route_from_city_id' )->select(['name'])->get();
    }

    public function getFromCountry(): \Illuminate\Database\Eloquent\Collection {
        return
            $this->hasOne(Country::class,'id','route_from_country_id' )->select(['name'])->get();
    }

    public function getToCity(): \Illuminate\Database\Eloquent\Collection {
        return
            $this->hasOne(Cities::class,'id','route_to_city_id' )->select(['name'])->get();
    }

    public function getToCountry(): \Illuminate\Database\Eloquent\Collection {
        return
            $this->hasOne(Country::class,'id','route_to_country_id' )->select(['name'])->get();
    }
}
