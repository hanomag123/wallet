<?php

namespace App\Models;

use App\Interfaces\Wallet as InterfacesWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model implements InterfacesWallet
{
  use HasFactory;

  protected $fillable = ['money'];

  public function Credit()
  {
  }

  public function Debit()
  {
  }

  public function Deposit()
  {
  }

  public function Withdraw()
  {
  }

  public function user():BelongsTo {
    return $this->belongsTo(User::class);
  }
}
