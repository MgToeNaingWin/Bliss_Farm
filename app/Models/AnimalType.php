<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalType extends Model
{
    use HasFactory;
    protected $table = 'animal_types';
    public function diseaseInfo()
{
    return $this->hasMany(DiseaseInfo::class,'animal_id');
}
}
