<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productTitle = $this->faker->text(rand(10, 40));
        $categoryLengthId = Category::all()->count();
        return [
            'title' => $productTitle,
            'slug' => Str::slug($productTitle),
            'description' => $this->faker->realText(100),
            'category_id' => $this->faker->numberBetween(1, $categoryLengthId),
            'price' => $this->faker->biasedNumberBetween(5, 2500),
            'stock' => $this->faker->numberBetween(1, 100),
            'photo' => $this->faker->imageUrl
        ];
    }
}
