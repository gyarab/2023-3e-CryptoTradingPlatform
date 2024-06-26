<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\FavouriteCryptoCurrency;
use WisdomDiala\Cryptocap\Facades\Cryptocap;


class DashboardController extends CryptoDetailController
{
    protected function renderDashboard2()
    {
        $favouriteCryptoCurrencies = $this->getFavouriteCryptoCurrencies();
        
        $ListOfCurrencies = [];

        foreach ($favouriteCryptoCurrencies as $key => $favouriteCryptoCurrency) {
            $ListOfCurrencies[] = $this->createObject($favouriteCryptoCurrency->name);
        }

        return Inertia::render('Dashboard', [
            'ListOfCurrencies' => $ListOfCurrencies,
            'error_message' => '',
            'favourite_cryptocurrency' => true,
            'url' => 'dashboard',
        ]);
    }

    protected function getFavouriteCryptoCurrencies() {
        $userId = Auth::id();

        $favouriteCryptoCurrencies = FavouriteCryptoCurrency::where('user_id', $userId)->get();

        return $favouriteCryptoCurrencies;
    }

    public function createObject($cryptocurrency) {
        $cryptocurrencyObject = new \stdClass();
        $cryptocurrencyObject->values = $this->getCryptoCurrencyValues($cryptocurrency);
        $cryptocurrencyObject->dataM = $this->getHistoryData($cryptocurrency, 'd1', 720);
        $cryptocurrencyObject->dataW = $this->getHistoryData($cryptocurrency, 'h2', 168);
        $cryptocurrencyObject->data6 = $this->getHistoryData($cryptocurrency, 'm15', 6);
        $cryptocurrencyObject->data24 = $this->getHistoryData($cryptocurrency, 'h1', 25);
        $cryptocurrencyObject->data12 = $this->getHistoryData($cryptocurrency, 'm30', 12.5);
        $cryptocurrencyObject->data1 = $this->getHistoryData($cryptocurrency, 'm1', 1);

        return $cryptocurrencyObject;
    }
}
