<?php

namespace App\Helper;

use App\Http\Controllers\CurrencyController;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Config;

class Helper {
    public static function getCurrency() {
        return CurrencyController::getCurrency();
    }

    public static function getCurrencyExchanges() {

        $currencyList = Config::get( 'app.currency_list' );

        $currencyExchange = [];
        foreach ( $currencyList as $key => $item ) {
            if ($key == Config::get( 'app.currency' )) continue;
            $currencyExchange[ $key ] = ExchangeRate::select( 'rate' )
                                                     ->where( 'currency', $key )
                                                     ->orderBy( 'id' )
                                                     ->limit( 1 )
                                                     ->first();
        }

        return $currencyExchange;
    }
}
