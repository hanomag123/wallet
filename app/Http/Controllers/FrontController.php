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

class FrontController extends Controller
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

    $newMoney = $walletFrom->money - $request->sum;
    $walletFrom->update(['money' => $newMoney]);
    $walletTo->update(['money' => $walletTo->money += $request->sum]);
    Log::info("Перевод от счета $walletFrom->id на счет $walletTo->id на сумму $request->sum Дата:" . date("Ymd"), [$walletFrom, $walletTo]);

    return redirect()
      ->back()
      ->with('success', 'карта пополнена успешно');
  }

  public function Deposit()
  {
  }

  public function Withdraw()
  {
  }
}
