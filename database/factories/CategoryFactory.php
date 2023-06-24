<?php

namespace Database\Factories;

use App\Models\CategoryType;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid'             => fake()->uuid,
            'title_en'         => fake()->unique()->words(1, true, 3),
            'title_bn'         => fake()->unique()->words(1, true, 3),
            'slug'             => fake()->unique()->words(1, true, 3),
            'category_type_id' => CategoryType::inRandomOrder()->first()->id,
            'order'            => fake()->unique()->numberBetween(1, 20),
        ];
    }
}
