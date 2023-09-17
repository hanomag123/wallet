<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Rules\IssetWallet;
use App\Rules\MaxMoney;
use App\Rules\WalletWithUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;

class WalletController extends Controller
{
  public function index(Request $request)
  {
    $wallets = $request->user()->wallets;
    $user = $request->user();

    return view('dashboard', compact('user', 'wallets'));
  }

  public function Debit(Request $request)
  {
    $user = $request->user();
    $walletFrom = Wallet::find($request->cardfrom);
    $walletTo = Wallet::find($request->cardto);


    $validator = Validator::make($request->all(), [
      'sum' => ['required', 'min:1', new MaxMoney($walletFrom),],
      'cardfrom' => ['required', 'min:1', new WalletWithUser($walletFrom, $user)],
      'cardto' => ['required', 'min:1', new IssetWallet($walletTo)],
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    $sum = $this->credit($request->sum, $walletFrom, $walletTo);

    $newMoney = $walletFrom->money - $request->sum;
    $walletFrom->update(['money' => $newMoney]);
    $walletTo->update(['money' => $walletTo->money += $sum]);
    Log::info("Перевод от счета $walletFrom->id на счет $walletTo->id на сумму $sum $walletTo->currency Дата:" . date("Y-m-d"), [$walletFrom, $walletTo]);

    return redirect()
      ->back()
      ->with('success', 'карта пополнена успешно');
  }


  public function createWallet(Request $request) {

    $user = $request->user();
    $wallet = Wallet::create([
      'currency' => $request->currency,
    ]);

    $wallet->user()->associate($user->id)->save();
    Log::info("Создан счет $wallet->id $wallet->currency пользователя $user->name Дата:" . date("Y-m-d"), [$wallet]);

    return redirect()
    ->back()
    ->with('success', 'карта успешно создана');
  }

  public function credit($sum, $walletFrom, $walletTo) {
    return $sum;
  }
}
