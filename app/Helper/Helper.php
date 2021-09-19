<?php
namespace App\Helper;

use App\Http\Controllers\CurrencyController;

class Helper
{
    public static function getCurrency(){
        return CurrencyController::getCurrency();
    }
}
