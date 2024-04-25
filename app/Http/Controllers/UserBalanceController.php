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

        $userBalance = $this->getData($userId, UserBalance::class, 'first');
        $favouriteCryptoCurrencies = $this->getData($userId, FavouriteCryptoCurrency::class);
        $userCryptoCurrencies = $this->getData($userId, BuyCryptocurrency::class);
        $userTrades = $this->getData($userId, Trade::class);
        $currenciesInfo = array();

        $favouriteCryptoCurrencies = $this->addToArray($favouriteCryptoCurrencies, 'symbol');
        $favouriteCryptoCurrencies = $this->addToArray($favouriteCryptoCurrencies, 'priceUsd');
        $favouriteCryptoCurrencies = $this->addToArray($favouriteCryptoCurrencies, 'changePercent24Hr');
        $userCryptoCurrencies = $this->addToArray($userCryptoCurrencies, 'symbol');
        $userCryptoCurrencies = $this->addToArray($userCryptoCurrencies, 'priceUsd');
        $userTrades = $this->addToArray($userTrades, 'symbol');

        $wealth = $this->calculateWealth($userCryptoCurrencies);

        return Inertia::render('Balance', [
            'balance' => $userBalance,
            'wealth' => $wealth,
            'favouriteCryptoCurrencies' => $favouriteCryptoCurrencies,
            'userCryptoCurrencies' => $userCryptoCurrencies,
            'userTrades' => $userTrades,
            'currenciesInfo' => $currenciesInfo,
        ]);
    }

    function calculateWealth($currencies) {
        $wealth = 0;

        foreach($currencies as $currency) {
            $x = (float) $currency['amount'];
            $y = (float) $currency['priceUsd'];
            $amountInUsd = $x * $y;
            $wealth += $amountInUsd;
        }

        return $wealth;
    }

    function getData($userId, $model, $function = 'get') {
        return $model::where('user_id', $userId)->$function();
    }

    function cryptoCurrencyInfo($cryptocurrency) {
        return Cryptocap::getSingleAsset($cryptocurrency);
    }

    function addToArray($array, $param) {
    // ChatGPT(add the param to the array)
        foreach ($array as $key => $currency) {
            $info = $this->cryptoCurrencyInfo($currency->name)->data;
    
            $array[$key]->$param = $info->$param;
        }

        return $array;
    }
}
