<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Auth;

class AddMoneyController extends Controller
{
    function addMoney(Request $request) {
        $this->validateData($request);

        $userId = Auth::id();
    
        $usdAmount = $request->input('amount');

        // Check if the user already has a record for the cryptocurrency
        $existingRecord = UserBalance::where('user_id', $userId)->first();

        if ($existingRecord) {
            // Update the existing record with the new amount
            $existingRecord->increment('balance', $usdAmount);
        } else {
            // Create a new record
            UserBalance::create([
                'user_id' => $userId,
                'balance' => $usdAmount,
            ]);
        }
    }

    function validateData(Request $request) {
        $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
        ]);
    }
}
