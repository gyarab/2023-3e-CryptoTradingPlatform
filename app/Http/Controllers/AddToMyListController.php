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

        if($this->doesRecordExist($cryptocurrencyName, $userId) === false) {
            FavouriteCryptoCurrency::create([
                'user_id' => $userId,
                'name' => $cryptocurrencyName,
            ]);
        }
    }

    function removeFromMyList(Request $request) {
        $userId = Auth::id();
        $cryptocurrencyName = strtolower($request->input('cryptocurrencyName'));

        if($this->doesRecordExist($cryptocurrencyName, $userId)) {
            $recordToDelete = FavouriteCryptoCurrency::where('user_id', $userId)
                                             ->where('name', $cryptocurrencyName)
                                             ->first();
            $recordToDelete->delete();
            return response()->json(['message' => 'Cryptocurrency removed from your list successfully!']);
        } else {
            return response()->json(['error' => 'Cryptocurrency not found in your list.']);
        }
    }

    function doesRecordExist($cryptocurrencyName, $userId) {
        $existingRecord = FavouriteCryptoCurrency::where('user_id', $userId)->where('name', $cryptocurrencyName)->first();

        if($existingRecord) {
            return true;
        } else {
            return false;
        }
    }
}
