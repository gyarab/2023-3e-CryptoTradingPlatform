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
    public function displayValues() 
    {
        $cryptocurrencies = Cryptocap::getAssetsWithLimit(5)->data;

        return Inertia::render('Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'cryptocurrencies' => $cryptocurrencies
        ]);
    }

    public function singleCryptoCurrency($cryptocurrency = null) 
    {
        // Validate user input
        $cryptocurrency = filter_var($cryptocurrency);

        $cryptocurrency = strtolower($cryptocurrency);
        
        $cryptocurrency_values = Cryptocap::getSingleAsset($cryptocurrency);
        if(!is_string($cryptocurrency))
        {
            //Invalid cryptocurrency name
            return Inertia::render('Dashboard', [
                'cryptocurrency' => $cryptocurrency_values,
                'error_message' => "Invalid name for a cryptocurrency",
            ]);

        }
        if(property_exists($cryptocurrency_values, "error"))
        {
            //The cryptocurrency doesn't exist
            return Inertia::render('Dashboard', [
                'cryptocurrency' => $cryptocurrency_values,
                'error_message' => "The crypto currency you searched for isn't in our database",
            ]);
        }

        return Inertia::render('Dashboard', [
            'cryptocurrency' => $cryptocurrency_values->data,
            'url' => $cryptocurrency,
        ]);
    }
}
