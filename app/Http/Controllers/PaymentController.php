<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
  public function sendMoneyToPayment(Request $request)
  {
    $wallet = Wallet::find($request->id);
    $this->sendMoney(5, $wallet);
    Log::info("На счет $wallet->id, получателю {$wallet->user->name} отправлено 5 успешно " . date("Y-m-d"), [$wallet]);
    return redirect()
      ->back()
      ->with('success', 'деньги успешно переведены');
  }

  public function getMoneyFromPayment(Request $request)
  {
    $wallet = Wallet::find($request->id);
    $this->getMoney(5, $wallet);
    Log::info("На счет $wallet->id, получателю {$wallet->user->name} отправлено 5 $wallet->currency успешно из платежной системы " . date("Y-m-d"), [$wallet]);
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
