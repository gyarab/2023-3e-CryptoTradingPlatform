<?php

use App\Http\Controllers\AddToMyListController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BuyCryptocurrencyController;
use App\Http\Controllers\UserBalanceController;
use App\Http\Controllers\CryptoDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard/{cryptocurrency}', [\App\Http\Controllers\CryptoDetailController::class, 'singleCryptoCurrency'])->middleware(['auth', 'verified'])->name('dashboard-search');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'renderDashboard2'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [\App\Http\Controllers\IndexController::class, 'renderIndex'])->name('index');

Route::get('dashboard/{cryptocurrency}/buy', [BuyCryptocurrencyController::class, 'displayPurchase'])->middleware(['auth', 'verified'])->name('buyCryptocurrency');

Route::post('/buy-crypto', [BuyCryptocurrencyController::class, 'buyCrypto']);

Route::post('/sell-crypto', [BuyCryptocurrencyController::class, 'sellCrypto']);

Route::post('/add-to-my-list', [AddToMyListController::class, 'addToMyList']);

Route::post('/remove-from-my-list', [AddToMyListController::class, 'removeFromMyList']);

Route::get('/balance', [UserBalanceController::class, 'displayBalance'])->middleware(['auth', 'verified'])->name('balance');

require __DIR__.'/auth.php';
