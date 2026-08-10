<?php
// app/Models/Livestock.php

namespace App\Models;

use App\Models\FeedingRecord;
use App\Models\HealthRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Livestock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tag_number',
        'name',
        'type',
        'gender',
        'date_of_birth',
        'breed',
        'color',
        'weight',
        'status',
        'parent_id',
        'user_id',
        'notes'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'weight' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Livestock::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Livestock::class, 'parent_id');
    }

    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class);
    }

    public function feedingRecords()
    {
        return $this->hasMany(FeedingRecord::class);
    }

    // Accessors
    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return $this->date_of_birth->diffInYears(now());
        }
        return null;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
