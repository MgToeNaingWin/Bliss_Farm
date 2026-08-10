<?php
// app/Models/FeedingRecord.php

namespace App\Models;
use App\Models\Livestock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'livestock_id',
        'record_date',
        'feed_type',
        'quantity',
        'unit',
        'feeding_time',
        'notes'
    ];

    protected $casts = [
        'record_date' => 'date',
        'feeding_time' => 'datetime:H:i', // Add this line
        'quantity' => 'decimal:2'
    ];

    public function livestock()
    {
        return $this->belongsTo(Livestock::class);
    }
}