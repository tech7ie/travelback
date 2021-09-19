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
}
