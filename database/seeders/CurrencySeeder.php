<?php

namespace Database\Seeders;

use App\Services\getCurrency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        getCurrency::getRate('byn', 'usd');
        getCurrency::getRate('byn', 'eur');
        getCurrency::getRate('usd', 'eur');
    }
}
