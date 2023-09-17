<?php

namespace App\Providers;

use App\Models\Currency;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    View::composer('*', function ($view) {
      $date = date('Y-m-d');
      $currencies = Currency::where('date', $date)->get();
      $view->with('currencies', $currencies);
    });
  }
}
