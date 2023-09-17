<?php

use App\Http\Controllers\WalletWithCurrencyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [WalletWithCurrencyController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/debit', [WalletWithCurrencyController::class, 'Debit'])->name('wallet.debit');
    Route::post('/create', [WalletWithCurrencyController::class, 'createWallet'])->name('wallet.create');
    
    Route::post('/sendPay', [PaymentController::class, 'sendMoneyToPayment'])->name('payment.send');
    Route::post('/getPay', [PaymentController::class, 'getMoneyFromPayment'])->name('payment.get');

});

require __DIR__.'/auth.php';
