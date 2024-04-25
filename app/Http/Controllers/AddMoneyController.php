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

        $userBalance = UserBalance::where('user_id', $userId)->first();

        $newUserBalance = $userBalance->balance + $usdAmount;
        $userBalance->balance = $newUserBalance;
        $userBalance->save();

    }

    function validateData(Request $request) {
        $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
        ]);
    }
}
