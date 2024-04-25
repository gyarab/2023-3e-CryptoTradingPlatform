<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;
use App\Models\FavouriteCryptoCurrency;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use WisdomDiala\Cryptocap\Facades\Cryptocap;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class CryptoDetailController extends Controller
{
    public function singleCryptoCurrency($cryptocurrency = null) 
    {

        if($this->validateUserInput($cryptocurrency) == 1)
        {
            return $this->renderDashboard();
        }

        $cryptocurrency_values = $this->getCryptoCurrencyValues($cryptocurrency);

        if($this->validateUserInput($cryptocurrency) == 2)
        {

            return $this->renderDashboard("Invalid name for a cryptocurrency");

        }
        if($this->validateUserInput($cryptocurrency) == 3)
        {
            return $this->renderDashboard("The crypto currency you've searched for isn't in our database");
        }

        $cryptoDataIn1M = $this->getHistoryData($cryptocurrency, 'd1', 720);
        $cryptoDataIn1W = $this->getHistoryData($cryptocurrency, 'h2', 168);
        $cryptoDataIn24 = $this->getHistoryData($cryptocurrency, 'h1', 25); 
        $cryptoDataIn12 = $this->getHistoryData($cryptocurrency, 'm30', 12.5); 
        $cryptoDataIn6 = $this->getHistoryData($cryptocurrency, 'm15', 6);
        $cryptoDataIn1 = $this->getHistoryData($cryptocurrency, 'm1', 1);

        $favouriteCryptoCurrency = $this->isFavourite($cryptocurrency);

        return $this->renderDashboard(null, $cryptocurrency_values, $cryptocurrency, $cryptoDataIn1M, $cryptoDataIn1W, $cryptoDataIn24, $cryptoDataIn12, $cryptoDataIn6, $cryptoDataIn1, $favouriteCryptoCurrency);
    }

    protected function getHistoryData($cryptocurrency, $interval, $time_period)
    {
        $rawHistoryData = json_decode(json_encode(Cryptocap::getAssetHistory($cryptocurrency, $interval)), true);
        $filteredHistoryData = $this->filterDataForTimeInterval($rawHistoryData, $time_period);

        return $filteredHistoryData;
    }

    private function validateUserInput($cryptocurrency)
    {
        if($cryptocurrency == null)
        {
            return 1;
        } elseif(!is_string($cryptocurrency))
        {
          return 2;
        }
        
        $cryptocurrency_values = $this->getCryptoCurrencyValues($cryptocurrency);

        if (is_object($cryptocurrency_values) && property_exists($cryptocurrency_values, "error")) 
        {
            return 3;
        }
    }

    protected function getCryptoCurrencyValues($cryptocurrency) 
    {
        $cryptocurrency = filter_var($cryptocurrency);

        $cryptocurrency = strtolower($cryptocurrency);
        
        $cryptocurrency_values = Cryptocap::getSingleAsset($cryptocurrency);

        return $cryptocurrency_values;
    }

    private function isFavourite($cryptocurrency) {
       $existingRecord = FavouriteCryptoCurrency::where('user_id', Auth::id())
       ->where('name', $cryptocurrency)
       ->first();

       if($existingRecord) {
        //it is user's favourite cryptocurrency

        return true;
       } else {

        return false;
       }
    }

    protected function renderDashboard($error_message = null, $cryptocurrency_values = null, $cryptocurrency = null, $cryptoDataIn1M = null, $cryptoDataIn1W = null, $cryptoDataIn24 = null, $cryptoDataIn12 = null, $cryptoDataIn6 = null, $cryptoDataIn1 = null, $favouriteCryptoCurrency = null)
    {
        if($cryptocurrency_values != null)
        {
            $cryptocurrency_values = $cryptocurrency_values->data;
        }
        return Inertia::render('Dashboard', [
            'cryptocurrency' => $cryptocurrency_values,
            'url' => $cryptocurrency, 
            'cryptoDataIn1M' => $cryptoDataIn1M,
            'cryptoDataIn1W' => $cryptoDataIn1W,
            'cryptoDataIn24' => $cryptoDataIn24,
            'cryptoDataIn12' => $cryptoDataIn12,
            'cryptoDataIn6' => $cryptoDataIn6,
            'cryptoDataIn1' => $cryptoDataIn1,
            'error_message' => $error_message,
            'favourite_cryptocurrency' => $favouriteCryptoCurrency,
        ]);
    }


    protected function filterDataForTimeInterval($data, $intervalInHours) 
    {
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
