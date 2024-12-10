<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('users')->insert([ ... ]);
        DB::table('roles')->insert([
            [
                'roleID' => 1,
                'isAdmin' => true,
                'description' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'roleID' => 2,
                'isAdmin' => false,
                'description' => 'Regular User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
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

        // Initialize the sales data array
        $sales = [];

        foreach ($products as $product) {
            $originalPrice = $product['price'];
            $retailedPrice = $originalPrice * 1.03; // 3% increase

            // Generate sales data for each month
            for ($month = 1; $month <= 12; $month++) {
                // Generate 5 to 10 random sales for the current month
                $numberOfSales = rand(5, 10);

                for ($i = 0; $i < $numberOfSales; $i++) {
                    // Ensure valid days for each month
                    $lastDayOfMonth = now()->setMonth($month)->lastOfMonth()->day;
                    $randomDay = rand(1, $lastDayOfMonth); // Random day within valid range
                    $createdAt = now()->setMonth($month)->setDay($randomDay)->setHour(rand(0, 23))->setMinute(rand(0, 59))->setSecond(rand(0, 59));
                    $updatedAt = $createdAt;

                    // Add the sales data to the array
                    $itemSold = rand(1, 10);
                    $totalSales = $retailedPrice * $itemSold;

                    $sales[] = [
                        'product_id' => $product['product_id'],
                        'item_sold' => $itemSold,
                        'retailed_price' => $retailedPrice,
                        'retrieve_price' => $originalPrice,
                        'total_sales' => $totalSales,
                        'created_at' => $createdAt,
                        'updated_at' => $updatedAt,
                    ];
                }
            }
        }
        // Insert the generated sales data for the year into the sales table
        DB::table('sales')->insert($sales);


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
