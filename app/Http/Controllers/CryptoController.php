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
        //fetching data from history

        $interval = 'm30';

        // Ensure the Cryptocap::getAssetHistory method supports the start and end parameters
        $history = Cryptocap::getAssetHistory($cryptocurrency, $interval);

        // Convert $history to an array
        $historyArray = json_decode(json_encode($history), true);

        $historyArray = $this->filterDataForTimeInterval($historyArray, 2);

        return Inertia::render('Dashboard', [
            'cryptocurrency' => $cryptocurrency_values->data,
            'url' => $cryptocurrency,
            'history' => $historyArray,
        ]);
    }

    // Function to filter data for the last 24 hours
    private function filterDataForTimeInterval($data, $intervalInHours) {
        // Convert interval to milliseconds
        $intervalInMilliseconds = $intervalInHours * 60 * 60 * 1000;
    
        $currentTimestampMs = round(microtime(true) * 1000);
        $startTimeMs = $currentTimestampMs - $intervalInMilliseconds;
    
        $filteredData = array_filter($data['data'], function ($item) use ($startTimeMs, $currentTimestampMs) {
            // Assuming the timestamp key in the data is 'time' (in milliseconds)
            return isset($item['time']) && $item['time'] >= $startTimeMs && $item['time'] <= $currentTimestampMs;
        });

        // Reindex the array to start from 0
        $filteredData = array_values($filteredData);
    
        return ['data' => $filteredData];
    }
}
