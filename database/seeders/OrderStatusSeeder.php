<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['Текущий', 'Завершён', 'Отменён'];

        foreach ($statuses as $status) {
            OrderStatus::create(['name' => $status]);
        }
    }
}
