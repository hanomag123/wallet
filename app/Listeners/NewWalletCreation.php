<?php

namespace App\Listeners;

use App\Models\Wallet;
use Illuminate\Auth\Events\Registered;

class NewWalletCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $wallet = Wallet::create([]);
        $wallet->user()->associate($event->user->id);
        $wallet->save();
    }
}
