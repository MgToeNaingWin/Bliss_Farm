<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiseaseInfo extends Model
{
    protected $fillable = [
        'animal_type_id',
        'disease_title',
        'disease_desc',
        'disease_img',
        'symptoms',
        'prevent',
        'treated',
        'view_count',
    ];

    public function animalType(): BelongsTo
    {
        return $this->belongsTo(AnimalType::class, 'animal_type_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'disease_info_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class, 'disease_info_id');
    }
}
