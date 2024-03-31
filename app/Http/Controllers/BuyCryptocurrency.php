<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class BuyCryptocurrency extends CryptoController
{
    function BuyCryptoCurrency($cryptocurrency) {
        return Inertia::render('Purchase', [
            'cryptocurrency' => $cryptocurrency,
        ]);
    }
}
