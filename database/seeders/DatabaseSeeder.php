<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call([
//            UsersTableSeeder::class,
//            ProductsTableSeeder::class
//        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

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
