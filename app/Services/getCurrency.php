<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class getCurrency
{
  public static function getSum($fromRate, $toRate, $sum)
  {


    if ($fromRate === $toRate) {
      // Если курсы одинаковые то возвращаем сумму неизменной
      return $sum;
      // Если курс рубля и доллара
    } else if ($fromRate === 'byn' && $toRate === 'usd' || $fromRate === 'usd' && $toRate === 'byn') {

      $rate = getCurrency::getRate('byn', 'usd');

      return getCurrency::BYNhandler($rate, $sum, $fromRate);
      // Если курс рубля и евро
    } else if ($fromRate === 'byn' && $toRate === 'eur' || $fromRate === 'eur' && $toRate === 'byn') {
      $rate = getCurrency::getRate('byn', 'eur');

      return getCurrency::BYNhandler($rate, $sum, $fromRate);
      // Если курс евро и доллара
    } else if ($fromRate === 'eur' && $toRate === 'usd' || $fromRate === 'usd' && $toRate === 'eur') {
      $rate = getCurrency::getRate($fromRate, $toRate);
      return getCurrency::USDhandler($rate, $sum, $fromRate);
    }
  }

  public static function getRate($from, $to)
  {

    if ($from === $to) {
      return 1;
    }

    // Получаем текущую дату
    $date = date('Y-m-d');

    if ($to === 'byn') {
      [$to, $from] = [$from, $to];
    } else if ($from === 'eur' && $to === 'usd') {
      [$to, $from] = [$from, $to];
    }

    // Проверяем есть ли уже такой курс на текущую дату
    $currency = Currency::where('date', $date)->where('from', $from)->where('to', $to)->first();

    if (isset($currency, $currency->rate)) {
      return $currency->rate;
    }

    if ($from === 'byn' || $to === 'byn') {

      $to = strtoupper($to);
      // Делаем запрос на получение курса рубля к доллару на искомую дату
      $response = Http::withoutVerifying()->get("https://api.nbrb.by/exrates/rates/$to?parammode=2&ondate=$date");
      $to = strtolower($to);
      //Если ответ успешен
      if ($response->successful()) {

        $response = $response->json();

        $rate = $response['Cur_OfficialRate'];

        $currency = Currency::create([
          'from' => $from,
          'to' => $to,
          'date' => $date,
          'rate' => $rate,
        ]);
        Log::info("Получено значение текущего курса по API BYNEUR $rate");
        return $currency->rate;
      } else {
        $rate = 3;
        $currency = Currency::create([
          'from' => $from,
          'to' => $to,
          'date' => $date,
          'rate' => $rate,
        ]);
        Log::info("Получено значение текущего курса по BYNUSD $rate");
        return $currency->rate;
      }
    } else if ($from === 'eur' && $to === 'usd' || $from === 'usd' && $to === 'eur') {
      // Делаем запрос на получение курса доллара к евро на искомую дату
      $response = Http::withoutVerifying()->get("https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_07yrNG4uUEHoa2mBsGzKTeRShP4iHXWBJaf8zf3F&currencies=EUR%2CUSD");

      //Если ответ успешен, то преобразуем его в массив
      if ($response->successful()) {

        $response = $response->json();
        $rate = $response['data']['EUR'];

        Log::info("Получено значение текущего курса по API USDEUR $rate");
        $currency = Currency::create([
          'from' => $from,
          'to' => $to,
          'date' => $date,
          'rate' => $rate,
        ]);
        return $rate;
      } else {
        $rate = 0.9;
        Log::info("Получено значение текущего курса по API USDEUR $rate");
        $currency = Currency::create([
          'from' => $from,
          'to' => $to,
          'date' => $date,
          'rate' => $rate,
        ]);
        return $rate;
      }
    }
  }

  private static function BYNhandler($rate, $sum, $from)
  {
    if ($from === 'byn') {
      return $sum / $rate;
    } else {
      return $sum * $rate;
    }
  }

  private static function USDhandler($rate, $sum, $from)
  {
    if ($from === 'usd') {
      return $sum / $rate;
    } else {
      return $sum * $rate;
    }
  }
}
