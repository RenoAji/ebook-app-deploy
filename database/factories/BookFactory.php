<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(rand(1,5), true),
            'author' => fake()->name(),
            'content' => fake()->paragraphs(20, true),
            'description' => fake()->sentences(rand(10,15), true),
            'cover' => 'image/noimage.jfif',
            'stock' => rand(2,15),
        ];
    }
}
