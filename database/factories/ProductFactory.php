<?php

namespace Database\Factories;

use App\Models\Digital;
use App\Models\Grade;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(1000, 50000),
            'release' => fake()->dateTimeBetween('-100 years', 'now'),
            'stock' => fake()->numberBetween(0, 100),
            'img_url' => fake()->imageUrl(640, 480, 'product', true),
            'type_id' => Type::factory(),
            'grade_id' => Grade::factory(),
            'digital_id' => Digital::factory(),
            'created_at' => fake()->dateTimeBetween('-2 years'),
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
}
