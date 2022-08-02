<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slidesWithTrueStatus = Slider::factory()->count(3)->create([
            'status' => true
        ]);

        $slidesWithFalseStatus = Slider::factory()->count(2)->create();

    }
}
