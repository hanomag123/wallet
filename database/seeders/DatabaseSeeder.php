<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    $user = User::factory()->create([
      'name' => 'Test User',
      'email' => 'test@test.test',
      'password' => Hash::make('test')
    ]);
    Log::info('created user from seeder', [$user]);

    $wallet = Wallet::create(['money' => 20]);
    $wallet->user()->associate($user->id)->save();

    Log::info('created wallet from seeder', [$wallet]);

    $user = User::factory()->create([
      'name' => 'Test User 2',
      'email' => 'test2@test.test',
      'password' => Hash::make('test')
    ]);
    Log::info('created user from seeder', [$user]);

    $wallet = Wallet::create([]);
    $wallet->user()->associate($user->id)->save();

    Log::info('created wallet from seeder', [$wallet]);
  }
}
