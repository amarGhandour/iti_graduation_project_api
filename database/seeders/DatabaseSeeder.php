<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Review;
use App\Models\Slider;
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

        $colors = Color::factory()->count(5)->create();

        $products = Product::factory()->count(50)->create()->each(function ($product) use ($categories, $colors) {
            $product->categories()->attach($categories->random(2));
            $product->colors()->attach($colors->random(3));
            Review::factory()->count(10)->create([
                'product_id' => $product
            ]);
        });

        $categories->each(function ($category) {
            Slider::factory()->create([
                'route' => "products?category=$category->name",
            ]);
        });

        $slidesWithFalseStatus = Slider::factory()->create([
            'route' => "products?category=$categories[1]->name",
        ]);

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
