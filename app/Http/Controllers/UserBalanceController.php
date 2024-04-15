<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\FavouriteCryptoCurrency;
use App\Models\UserBalance;
use App\Models\Trade;
use App\Models\BuyCryptocurrency;

class UserBalanceController extends Controller
{
    function displayBalance() {
        $userId = Auth::id();

        $userBalance = $this->getData($userId, UserBalance::class);
        $favouriteCryptoCurrencies = $this->getData($userId, FavouriteCryptoCurrency::class);
        $userCryptoCurrencies = $this->getData($userId, BuyCryptocurrency::class);
        $userTrades = $this->getData($userId, Trade::class);

        return Inertia::render('Balance', [
            'balance' => $userBalance,
            'favouriteCryptoCurrencies' => $favouriteCryptoCurrencies,
            'userCryptoCurrencies' => $userCryptoCurrencies,
            'userTrades' => $userTrades,
        ]);
    }

    function getData($userId, $model) {
        return $model::where('user_id', $userId)->get();
    }
}
