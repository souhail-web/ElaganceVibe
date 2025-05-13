<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data

        // Add sample products
        Product::create([
            'name' => 'Sample Product 1',
            'description' => 'Description for sample product 1',
            'price' => 99.99,
            'quantity' => 10,
            'category' => 'male',
            'status' => 'available'
        ]);

        Product::create([
            'name' => 'Sample Product 2',
            'description' => 'Description for sample product 2',
            'price' => 149.99,
            'quantity' => 5,
            'category' => 'female',
            'status' => 'available'
        ]);

        // Add more products as needed
    }
}