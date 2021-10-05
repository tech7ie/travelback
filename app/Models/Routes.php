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

//        return $this->belongsToMany(Cities::class)
//                    ->where(function (Builder $query) {
//                        $query->where('country_id', 144);
//                    });

//        return $this->belongsToMany(Cities::class)->wherePivotIn('cities.country_id', [144]);
//        return $this->belongsToMany(Cities::class)->wherePivotIn('country_id', [1, 2]);
//        return $this->belongsToMany("Cities")->where('country_id', '=', 144);

//        $result = $this->belongsToMany(Cities::class);
//        $result->getQuery()->where("country_id", "=", 144);
//        print_r($result->get());
//        return $result;

        return $this->morphToMany(Cities::class, 'cities_route');
//        return $this->belongsToMany(Cities::class)->where('country_id', '=', Country::select('id')->where('region' ,'=', 'Europe'))->get();
//        return $this->belongsToMany(Cities::class)->where('country_id', '=', 0);
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
