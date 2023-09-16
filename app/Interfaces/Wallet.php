<?php
namespace App\Interfaces;

interface Wallet {
  public function Credit ();
  public function Debit();
  public function Deposit();
  public function Withdraw();
};
?>