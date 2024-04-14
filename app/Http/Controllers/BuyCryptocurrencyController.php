<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\BuyCryptocurrency;




class BuyCryptocurrencyController extends CryptoController
{
    function displayPurchase($cryptocurrency) {
        $cryptocurrency_values = $this->getCryptoCurrencyValues($cryptocurrency)->data;

        return Inertia::render('Purchase', [
            'cryptocurrency' => $cryptocurrency_values,
        ]);
    }

    public function buyCrypto(Request $request) {
        // Validate the request data
        $request->validate([
            'cryptocurrency' => 'required|string|max:50',
            'amount' => 'required|numeric',
        ]);

        // Get the authenticated user's ID
        $userId = Auth::id();

        //Check if user has enough money to buy the currency

        // Check if the user already has a record for the cryptocurrency
        $existingRecord = BuyCryptocurrency::where('user_id', $userId)
            ->where('name', $request->input('cryptocurrency'))
            ->first();

        if ($existingRecord) {
            // Update the existing record with the new amount
            $existingRecord->increment('amount', $request->input('amount'));
        } else {
            // Create a new record
            BuyCryptocurrency::create([
                'user_id' => $userId,
                'name' => $request->input('cryptocurrency'),
                'amount' => $request->input('amount'),
            ]);
        }

        // Render the Purchase view with a success message or any other data you want to pass
        return Inertia::render('Purchase', [
            'cryptocurrency' => 'done',
            'message' => 'Cryptocurrency bought successfully.',
        ]);
    }

    function sellCrypto($cryptocurrency, $amount) {

    }
}
