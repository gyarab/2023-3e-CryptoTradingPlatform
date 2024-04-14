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
        return Inertia::render('Balance', [
        ]);
    }

    function getUserBalance() {

    }
    
    function getFavouriteCryptoCurrencies() {

    }

    function getUserCryptocurrencies() {

    }

    function getUserTrades() {

    }
}
