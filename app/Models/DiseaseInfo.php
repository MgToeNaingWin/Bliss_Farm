<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseInfo extends Model
{
    /** @use HasFactory<\Database\Factories\DiseaseInfoFactory> */
    use HasFactory;
    public function animalType()
{
    return $this->belongsTo(AnimalType::class);
}
}
