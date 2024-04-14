<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FavouriteCryptoCurrency;

class AddToMyListController extends Controller
{
    function addToMyList(Request $request) {
        $userId = Auth::id();
        $cryptocurrencyName = strtolower($request->input('cryptocurrencyName'));

        FavouriteCryptoCurrency::create([
            'user_id' => $userId,
            'name' => $cryptocurrencyName,
        ]);
    }

    function removeFromMyList(Request $request) {

    }
}
