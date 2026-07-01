<?php

namespace Database\Factories;

use App\Models\AnimalType;
use App\Models\DiseaseInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiseaseInfoFactory extends Factory
{
    protected $model = DiseaseInfo::class;

    public function definition(): array
    {
        return [
            'animal_type_id' => AnimalType::factory(),

            'disease_title' => $this->faker->words(3, true),
            'disease_desc' => $this->faker->paragraph(),
            'disease_img' => $this->faker->imageUrl(640, 480, 'disease'),
            'symptoms' => $this->faker->sentence(),
            'prevent' => $this->faker->sentence(),
            'treated' => $this->faker->sentence(),
        ];
    }
}