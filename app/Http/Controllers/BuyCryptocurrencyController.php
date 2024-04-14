<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\BuyCryptocurrency;
use App\Models\UserBalance;
use App\Models\Trade;


class BuyCryptocurrencyController extends CryptoController
{    //delete white spaces in cryptocalculator
    function displayPurchase($cryptocurrency) {
        $cryptocurrency_values = $this->getCryptoCurrencyValues($cryptocurrency)->data;

        return $this->renderView($cryptocurrency_values);
    }

    public function buyCrypto(Request $request) {
        $this->validateData($request);
        
        $userId = Auth::id();

        $cryptoAmount = $request->input('cryptoAmount');
        $cryptocurrency = $request->input('cryptocurrency');
        $usdAmount = $request->input('usdAmount');

        //Check if user has enough money to buy the currency
        $userBalance = UserBalance::where('user_id', $userId)->first();

        if($userBalance->balance < $usdAmount) {
            //User has not enough money
            return $this->renderView($cryptocurrency, "You have not enough money");
        } else {
            //Decrease user balance by the amount
            $newUserBalance = $userBalance->balance - $usdAmount;
            $userBalance->balance = $newUserBalance;
            $userBalance->save();
        }


        // Check if the user already has a record for the cryptocurrency
        $existingRecord = BuyCryptocurrency::where('user_id', $userId)
            ->where('name', $request->input('cryptocurrency'))
            ->first();

        if ($existingRecord) {
            // Update the existing record with the new amount
            $existingRecord->increment('amount', $cryptoAmount);
        } else {
            // Create a new record
            BuyCryptocurrency::create([
                'user_id' => $userId,
                'name' => $request->input('cryptocurrency'),
                'amount' => $cryptoAmount,
            ]);
        }

        //Double check  if everything went okay

        $this->saveTrade($userId, $cryptocurrency, $cryptoAmount, $usdAmount, true);

        return $this->renderView($cryptocurrency, "Cryptocurrency was bought succesfully");
    }

    function sellCrypto(Request $request) {
        $this->validateData($request);

        $userId = Auth::id();
        
        $cryptoAmount = $request->input('cryptoAmount');
        $cryptocurrency = $request->input('cryptocurrency');
        $usdAmount = $request->input('usdAmount');

        //Check if the user has the cryptocurrency
        $existingRecord = BuyCryptocurrency::where('user_id', $userId)
            ->where('name', $request->input('cryptocurrency'))
            ->first();

        $userBalance = UserBalance::where('user_id', $userId)->first();

        if ($existingRecord) {
            if($cryptoAmount > $existingRecord->amount) {
                // User does not have enough crypto
                return $this->renderView($cryptocurrency, "Cryptocurrency was not sold succesfully");
            } else {
                $existingRecord->decrement('amount', $cryptoAmount);

                $newUserBalance = $userBalance->balance + $usdAmount;
                $userBalance->balance = $newUserBalance;
                $userBalance->save();
            }
        }

        $this->saveTrade($userId, $cryptocurrency, $cryptoAmount, $usdAmount, false);

        return $this->renderView($cryptocurrency, "Cryptocurrency was sold succesfully");
    }

    function renderView($cryptocurrency = null, $message = null) {
        return Inertia::render('Purchase', [
            'cryptocurrency' => $cryptocurrency,
            'message' => "$message",
        ]);
    }

    function validateData(Request $request) {
        $request->validate([
            'cryptocurrency' => 'required|string|max:50',
            'cryptoAmount' => ['required', 'numeric', 'gt:0'], // Amount must be greater than zero
            'usdAmount' => ['required', 'numeric', 'gt:0'], // Amount must be greater than zero
        ]);
    }

    function saveTrade($userId, $cryptocurrency, $cryptoAmount, $usdAmount, $boughtCrypto) {
        Trade::create([
            'user_id' => $userId,
            'name' => $cryptocurrency,
            'crypto_amount' => $cryptoAmount,
            'usd_amount' => $usdAmount,
            'bought_crypto' => $boughtCrypto,
        ]);
    }
}
