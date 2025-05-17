<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crée un utilisateur admin
        User::create([
            'first_name' => 'admin',
            'last_name' => 'test',
            'email' => 'admin@example.com',
            'phone' => '0766883783',
            'password' => Hash::make('admin123'),
            'usertype' => 'admin',
            'gender' => 'male',
        ]);

        // Appel des autres seeders (ajuste selon les seeders que tu as créés)
        $this->call([
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            CartSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
