<?php

namespace Database\Factories;
use Faker\Generator as faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ViewCount>
 */
class ViewCountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        return [
            // 'week' => $faker->unique()->numberBetween(1, 52), // Assuming 'week' is a field representing the week number
            // 'blog_post_id' => $faker->numberBetween(100, 1000), // Random views count
            // 'created_at' => $faker->dateTimeBetween('-7 days', 'now'), // Date within the past 7 days
        ];
    }
}
