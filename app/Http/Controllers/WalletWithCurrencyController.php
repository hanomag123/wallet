<?php

namespace App\Http\Controllers;


use App\Services\getCurrency;
use Illuminate\Http\Request;


class WalletWithCurrencyController extends WalletController
{

  public function createWallet(Request $request) {
    if (!in_array($request->currency, ['usd', 'byn', 'eur'])) {
      return abort(404);
    }

    return parent::createWallet($request);
  }
  
  public function credit($sum, $walletFrom, $walletTo) {
    $sum = getCurrency::getSum($walletFrom->currency, $walletTo->currency, $sum);
    return parent::credit($sum, $walletFrom, $walletTo);
  }
}
