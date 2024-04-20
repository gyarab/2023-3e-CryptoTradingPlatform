<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\FavouriteCryptoCurrency;
use App\Models\UserBalance;
use App\Models\Trade;
use App\Models\BuyCryptocurrency;
use Illuminate\Support\Arr;
use WisdomDiala\Cryptocap\Facades\Cryptocap;

class UserBalanceController extends Controller
{
    function displayBalance() {
        $userId = Auth::id();

        $userBalance = $this->getData($userId, UserBalance::class);
        $favouriteCryptoCurrencies = $this->getData($userId, FavouriteCryptoCurrency::class);
        $userCryptoCurrencies = $this->getData($userId, BuyCryptocurrency::class);
        $userTrades = $this->getData($userId, Trade::class);
        $currenciesInfo = array();

        $favouriteCryptoCurrencies = $this->addToArray($favouriteCryptoCurrencies, 'symbol');
        $favouriteCryptoCurrencies = $this->addToArray($favouriteCryptoCurrencies, 'priceUsd');
        $favouriteCryptoCurrencies = $this->addToArray($favouriteCryptoCurrencies, 'changePercent24Hr');
        $userCryptoCurrencies = $this->addToArray($userCryptoCurrencies, 'symbol');
        $userTrades = $this->addToArray($userTrades, 'symbol');

        return Inertia::render('Balance', [
            'balance' => $userBalance,
            'favouriteCryptoCurrencies' => $favouriteCryptoCurrencies,
            'userCryptoCurrencies' => $userCryptoCurrencies,
            'userTrades' => $userTrades,
            'currenciesInfo' => $currenciesInfo,
        ]);
    }

    function getData($userId, $model) {
        return $model::where('user_id', $userId)->get();
    }

    function cryptoCurrencyInfo($cryptocurrency) {
        return Cryptocap::getSingleAsset($cryptocurrency);
    }

    function addToArray($array, $param) {

        foreach ($array as $key => $currency) {
            $info = $this->cryptoCurrencyInfo($currency->name)->data;
    
            $array[$key]->$param = $info->$param;
            //$array[$key]->$param2 = $info->$param2;
        }

        return $array;
    }
}
