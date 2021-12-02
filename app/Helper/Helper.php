<?php

namespace App\Helper;

use App\Http\Controllers\Currency;
use App\Http\Controllers\CurrencyController;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Config;

class Helper {
    public static function getCurrency() {
        return CurrencyController::getCurrency();
    }

    public static function getCurrencyList() {
//        return CurrencyController::getCurrency();

//        'currency_list' => [
//            'usd' => 'U.S. Dollar',
//            'aud' => 'Australian Dollar',
//            'eur' => 'Euro',
//        ],

        $currencyList = \App\Models\Currency::select()->where( 'status', true )->get();

        $currencyListResponse = [];
        foreach ( $currencyList as $item ) {
            $currencyListResponse[$item['currency']] =  $item['label'];
        }

        return $currencyListResponse;
//        return $currencyList;

    }

    public static function getCurrencyExchanges() {

//        $currencyList = Config::get( 'app.currency_list' );
        $currencyList = self::getCurrencyList();

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
