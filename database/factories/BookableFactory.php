<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookable>
 */
class BookableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $suffix = [
            'villa',
            'House',
            'Cottage',
            'Luxury Villa',
            'Cheap House',
            'Rooms',
            'Cheap Rooms',
            'Luxury Rooms',
            'Fancy Rooms',
        ];
        return [
            'title' => fake()->city . ' '. Arr::random($suffix),
            'description' => fake()->text(),
            'price' => random_int(150, 1000)
        ];
    }
}
