<?php

namespace Database\Factories;

use App\Models\AnimalType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type_title' => $this->faker->randomElement(['Cow', 'Goat', 'Chicken', 'Sheep','Pig']),
            'type_desc' => $this->faker->sentence(),
            'type_img' => $this->faker->imageUrl(640, 480, 'animals'),
        ];
    }
}