<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory()->create()->id,
            'name' => $name = fake()->name(),
            'slug' => Str::slug($name),
            'additional_price' => rand(10000, 100000),
            'grams' => rand(0.5, 10),
        ];
    }
}
