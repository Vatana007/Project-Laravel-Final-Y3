<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // 2. Create Default Categories
        $drink = Category::create(['name' => 'Drinks']);
        $food = Category::create(['name' => 'Food']);

        // 3. Create Sample Products
        Product::create([
            'category_id' => $drink->id,
            'name' => 'Coca Cola',
            'barcode' => '8880001',
            'cost_price' => 0.50,
            'sale_price' => 1.00,
            'qty' => 100
        ]);
        
        Product::create([
            'category_id' => $food->id,
            'name' => 'Sandwich',
            'barcode' => '8880002',
            'cost_price' => 1.50,
            'sale_price' => 3.50,
            'qty' => 50
        ]);
    }
}