<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use WisdomDiala\Cryptocap\Facades\Cryptocap;

use function Laravel\Prompts\error;

class CryptoController extends Controller
{
    public function displayValues() 
    {
        $cryptocurrencies = Cryptocap::getAssetsWithLimit(5);
        $error_message = null;

        //ošetřit, když nefunguje cryptocap
        if($cryptocurrencies == null)
        {
            $error_message = "No response from api";
        }   else
            {
                $cryptocurrencies = $cryptocurrencies->data;
            }

        return Inertia::render('Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'cryptocurrencies' => $cryptocurrencies,
            'error_message' => $error_message,
        ]);
    }

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

        $cryptoDataIn24 = $this->getHistoryData($cryptocurrency, 'h1', 25);
        $cryptoDataIn12 = $this->getHistoryData($cryptocurrency, 'm30', 12.5);
        $cryptoDataIn1 = $this->getHistoryData($cryptocurrency, 'm1', 1);

        return $this->renderDashboard(null, $cryptocurrency_values, $cryptocurrency, $cryptoDataIn24, $cryptoDataIn12, $cryptoDataIn1);
    }

    private function getHistoryData($cryptocurrency, $interval, $time_period)
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
        
        $cryptocurrency = filter_var($cryptocurrency);

        $cryptocurrency = strtolower($cryptocurrency);
        
        $cryptocurrency_values = Cryptocap::getSingleAsset($cryptocurrency);

        if(property_exists($cryptocurrency_values, "error"))
        {
            return 3; //upravit vyjímku nefunguje kdyz nefunguje cryptocap
        }
    }

    private function getCryptoCurrencyValues($cryptocurrency) {
        $cryptocurrency = filter_var($cryptocurrency);

        $cryptocurrency = strtolower($cryptocurrency);
        
        $cryptocurrency_values = Cryptocap::getSingleAsset($cryptocurrency);

        return $cryptocurrency_values;
    }

    private function renderDashboard($error_message = null, $cryptocurrency_values = null, $cryptocurrency = null, $cryptoDataIn24 = null, $cryptoDataIn12 = null, $cryptoDataIn1 = null)
    {
        if($cryptocurrency_values != null)
        {
            $cryptocurrency_values = $cryptocurrency_values->data;
        }
        return Inertia::render('Dashboard', [
            'cryptocurrency' => $cryptocurrency_values,
            'url' => $cryptocurrency,
            'cryptoDataIn24' => $cryptoDataIn24,
            'cryptoDataIn12' => $cryptoDataIn12,
            'cryptoDataIn1' => $cryptoDataIn1,
            'error_message' => $error_message,
        ]);
    }


    private function filterDataForTimeInterval($data, $intervalInHours) 
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
