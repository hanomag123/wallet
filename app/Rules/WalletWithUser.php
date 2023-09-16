<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WalletWithUser implements ValidationRule
{
  /**
   * Run the validation rule.
   *
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */

  private $wallet;
  private $user;

  public function __construct($wallet, $user)
  {
    $this->wallet = $wallet;
    $this->user = $user;
  }
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    if (!isset($this->wallet) || $this->wallet->user_id !== $this->user->id) {
      $fail('Нет такой карты.');
    }
  }
}
