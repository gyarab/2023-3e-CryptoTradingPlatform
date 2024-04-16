<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use WisdomDiala\Cryptocap\Facades\Cryptocap;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class IndexController extends Controller
{
    public function renderIndex() 
    {
        $arr = $this->getCryptoData();

        return Inertia::render('Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'cryptocurrencies' => $arr['data'],
            'error_message' => $arr['message'],
        ]);
    }

    public function getCryptoData() {
        $cryptocurrencyData = Cryptocap::getAssetsWithLimit(5);
        $error_message = null; 

        if($cryptocurrencyData == null)
        {
            $error_message = "No response from api";
        }   else
            {
                $cryptocurrencyData = $cryptocurrencyData->data;
            }

        return array(
            'data' => $cryptocurrencyData, 
            'message' => $error_message
        );
    }
}
