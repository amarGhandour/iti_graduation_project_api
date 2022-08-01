<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $categories = Category::factory()->count(5)->create();

        Product::factory()->count(50)->create()->each(function ($product) use ($categories) {
            $product->categories()->attach($categories->random(2));
        });

        Coupon::insert([[
            'code' => 'ABC123',
            'type' => 'fixed',
            'value' => 3000
        ]]);

        Coupon::insert([
            'code' => 'DEF567',
            'type' => 'percent',
            'percent_off' => 15
        ]);

    }
}
