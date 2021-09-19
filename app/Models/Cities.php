<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Prepare table
//UPDATE `cities` SET `label`= CONCAT(`name`,',',`country_code`) WHERE id >=0

class Cities extends Model
{
    use HasFactory;


    function index(){
        return $this->where('country_id' ,'=', 144)->get();
//        return $this->where('country_id' ,'IN', (Country::select('id')->where('region' ,'=', 'Europe')->get()))->get();
    }

    function euList(){
        return $this->where('country_id' ,'IN', (Country::select('id')->where('region' ,'=', 'Europe')->get()))->get();
    }
}
