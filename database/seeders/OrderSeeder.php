<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // On suppose que l'utilisateur ID = 1 et cart ID = 1 existent
        for ($i = 0; $i < 5; $i++) {
            Order::create([
                'user_id'      => 3,
                'cart_id'      => 1,
                'total_amount' => rand(50, 200),
                'status'       => collect(['pending', 'paid', 'cancelled'])->random(),
            ]);
        }
    }
}
