<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        Cart::create([
            'user_id' => 3, // l'admin qu'on a déjà créé
            // Ajoute ici d'autres champs obligatoires si ta table `carts` en contient
        ]);
    }
}
