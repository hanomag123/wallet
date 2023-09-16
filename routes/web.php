<?php

use App\Http\Controllers\FrontController;
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

Route::get('/dashboard', [FrontController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/debit', [FrontController::class, 'Debit'])->name('wallet.debit');

Route::post('/sendPay', [PaymentController::class, 'sendMoneyToPayment'])->name('payment.send');
Route::post('/getPay', [PaymentController::class, 'getMoneyFromPayment'])->name('payment.get');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';