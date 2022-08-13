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

        $products = Product::factory()->count(50)->create(['image' => null])->each(function ($product) use ($categories, $colors) {
            $product->categories()->attach($categories->random(1));
            $product->colors()->attach($colors->random(3));
            Review::factory()->count(10)->create([
                'product_id' => $product
            ]);
        });


        $slidesWithTrueStatus = Slider::factory()->create([
            'link' => "products?category=" . $categories[1]->name,
            'category_id' => $categories[1],
            'status' => true
        ]);

        $slidesWithFalseStatus = Slider::factory()->create([
            'link' => "products?category=" . $categories[2]->name,
            'category_id' => $categories[2],
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
