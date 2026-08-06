<?php

// app/Models/AnimalType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnimalType extends Model
{
    protected $fillable = ['type_title', 'type_desc', 'type_img'];

    public function diseases(): HasMany
    {
        return $this->hasMany(DiseaseInfo::class, 'animal_type_id');
    }
}
