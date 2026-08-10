<?php
// app/Models/HealthRecord.php

namespace App\Models;

use App\Models\Livestock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'livestock_id',
        'record_date',
        'type',
        'title',
        'description',
        'medication',
        'dosage',
        'next_due_date',
        'administered_by',
        'cost',
        'notes'
    ];

    protected $casts = [
        'record_date' => 'date',
        'next_due_date' => 'date',
        'cost' => 'decimal:2'
    ];

    public function livestock()
    {
        return $this->belongsTo(Livestock::class);
    }

    public function administrator()
    {
        return $this->belongsTo(User::class, 'administered_by');
    }
}
