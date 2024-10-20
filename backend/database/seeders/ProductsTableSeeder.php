<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_id' => $productId1 = Str::random(15),
                'name' => 'Notebook',
                'price' => 12.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId2 = Str::random(15),
                'name' => 'Pen',
                'price' => 1.25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId3 = Str::random(15),
                'name' => 'Pencil',
                'price' => 0.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId4 = Str::random(15),
                'name' => 'Eraser',
                'price' => 0.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId5 = Str::random(15),
                'name' => 'Ruler',
                'price' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert products into the products table
        DB::table('products')->insert($products);

        DB::table('category')->insert([
            [
                'product_id' => $productId1,
                'category' => 'School Supplies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId2,
                'category' => 'Office Supplies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId3,
                'category' => 'Art Supplies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId4,
                'category' => 'Stationery',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId5,
                'category' => 'Technology',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert corresponding sales records
        DB::table('sales')->insert([
            [
                'product_id' => $productId1,
                'item_sold' => 100,
                'total_sales' => 1250.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId2,
                'item_sold' => 200,
                'total_sales' => 250.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId3,
                'item_sold' => 150,
                'total_sales' => 112.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId4,
                'item_sold' => 300,
                'total_sales' => 150.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId5,
                'item_sold' => 50,
                'total_sales' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert corresponding reports records
        DB::table('reports')->insert([
            [
                'product_id' => $productId1,
                'reports' => 'Good quality and high demand.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId2,
                'reports' => 'Sold out faster than expected.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId3,
                'reports' => 'Steady sales, high school use.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId4,
                'reports' => 'Frequent purchases, popular among students.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId5,
                'reports' => 'High demand from engineers.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert corresponding stocks records
        DB::table('stocks')->insert([
            [
                'product_id' => $productId1,
                'stocks' => 1000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId2,
                'stocks' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId3,
                'stocks' => 300,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId4,
                'stocks' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId5,
                'stocks' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
