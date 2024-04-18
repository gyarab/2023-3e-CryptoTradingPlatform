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

        foreach($favouriteCryptoCurrencies as $key => $currency) {
            $currenciesInfo[] = $this->cryptoCurrencyInfo($currency->name);
        }

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
}
