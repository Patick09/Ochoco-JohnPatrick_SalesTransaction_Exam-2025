<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Gaming Laptop',
                'description' => 'High-performance gaming laptop with RTX graphics',
                'category' => 'Electronics',
                'selling_price' => 89999.99,
                'cost_price' => 65000.00,
                'stock_quantity' => 5,
                'minimum_stock' => 2,
                'supplier' => 'TechCorp Philippines',
                'status' => 'active'
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with RGB lighting',
                'category' => 'Electronics',
                'selling_price' => 2500.00,
                'cost_price' => 1500.00,
                'stock_quantity' => 25,
                'minimum_stock' => 10,
                'supplier' => 'Peripheral Solutions',
                'status' => 'active'
            ],
            [
                'name' => '24-inch Monitor',
                'description' => 'Full HD monitor with 75Hz refresh rate',
                'category' => 'Electronics',
                'selling_price' => 12000.00,
                'cost_price' => 8500.00,
                'stock_quantity' => 8,
                'minimum_stock' => 3,
                'supplier' => 'DisplayTech Inc',
                'status' => 'active'
            ],
            [
                'name' => 'Office Chair',
                'description' => 'Ergonomic office chair with lumbar support',
                'category' => 'Furniture',
                'selling_price' => 15000.00,
                'cost_price' => 10000.00,
                'stock_quantity' => 12,
                'minimum_stock' => 5,
                'supplier' => 'Furniture World',
                'status' => 'active'
            ],
            [
                'name' => 'Coffee Mug',
                'description' => 'Ceramic coffee mug with company logo',
                'category' => 'Office Supplies',
                'selling_price' => 250.00,
                'cost_price' => 150.00,
                'stock_quantity' => 50,
                'minimum_stock' => 20,
                'supplier' => 'Promo Items Co',
                'status' => 'active'
            ],
            [
                'name' => 'Notebook Set',
                'description' => 'Set of 3 spiral notebooks with different colors',
                'category' => 'Office Supplies',
                'selling_price' => 150.00,
                'cost_price' => 80.00,
                'stock_quantity' => 30,
                'minimum_stock' => 15,
                'supplier' => 'Stationery Plus',
                'status' => 'active'
            ],
            [
                'name' => 'Ballpoint Pen',
                'description' => 'Blue ink ballpoint pen with comfortable grip',
                'category' => 'Office Supplies',
                'selling_price' => 25.00,
                'cost_price' => 12.00,
                'stock_quantity' => 100,
                'minimum_stock' => 50,
                'supplier' => 'Writing Tools Ltd',
                'status' => 'active'
            ],
            [
                'name' => 'Bluetooth Headphones',
                'description' => 'Noise-cancelling wireless headphones',
                'category' => 'Electronics',
                'selling_price' => 4500.00,
                'cost_price' => 2800.00,
                'stock_quantity' => 0,
                'minimum_stock' => 5,
                'supplier' => 'AudioTech Solutions',
                'status' => 'active'
            ],
            [
                'name' => 'Desk Lamp',
                'description' => 'LED desk lamp with adjustable brightness',
                'category' => 'Furniture',
                'selling_price' => 1800.00,
                'cost_price' => 1200.00,
                'stock_quantity' => 3,
                'minimum_stock' => 5,
                'supplier' => 'Lighting Solutions',
                'status' => 'active'
            ],
            [
                'name' => 'Old Keyboard',
                'description' => 'Mechanical keyboard (discontinued model)',
                'category' => 'Electronics',
                'selling_price' => 3500.00,
                'cost_price' => 2500.00,
                'stock_quantity' => 2,
                'minimum_stock' => 5,
                'supplier' => 'Keyboard Masters',
                'status' => 'discontinued'
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}



