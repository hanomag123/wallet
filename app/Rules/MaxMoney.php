<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxMoney implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    private $wallet;
    public function __construct($wallet)
    {
      $this->wallet = $wallet;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
      if (!isset($this->wallet)) {
        return;
      }
      if ($this->wallet->money < $value) {
        $fail('Недостаточно средств.');
      }
    }
}
