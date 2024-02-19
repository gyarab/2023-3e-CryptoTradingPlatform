<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use WisdomDiala\Cryptocap\Facades\Cryptocap;

class CryptoController extends Controller
{
    public function displayValues() {
        $cryptocurrencies = Cryptocap::getAssets()->data;

        return Inertia::render('Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'cryptocurrencies' => $cryptocurrencies
        ]);
    }
}
