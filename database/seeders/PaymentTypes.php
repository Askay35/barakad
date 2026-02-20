<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentType::create([
            'name' => 'Наличные',
        ]);
        PaymentType::create([
            'name' => 'Карта',
        ]);
    }
}
