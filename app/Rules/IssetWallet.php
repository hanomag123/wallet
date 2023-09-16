<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IssetWallet implements ValidationRule
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
        $fail('Нет такой карты');
      }
    }
}
