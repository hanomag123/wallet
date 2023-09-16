<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
  public function sendMoneyToPayment(Request $request)
  {
    $wallet = Wallet::find($request->id);
    $this->sendMoney(5, $wallet);
    return redirect()
      ->back()
      ->with('success', 'деньги успешно переведены');
  }

  public function getMoneyFromPayment(Request $request)
  {
    $wallet = Wallet::find($request->id);
    $this->getMoney(5, $wallet);
    return redirect()
      ->back()
      ->with('success', 'карта пополнена успешно');
  }


  public function getMoney($sum, $wallet)
  {
    if (!isset($wallet)) {
      return;
    }
    return $wallet->update(['money' => $wallet->money + $sum]);
  }



  public function sendMoney($sum, $wallet)
  {
    if (!isset($wallet)) {
      return;
    }
    if ($wallet->money - $sum < 0) {
      return 'Недостаточно средств';
    }
    return $wallet->update(['money' => $wallet->money - $sum]);
  }
}
