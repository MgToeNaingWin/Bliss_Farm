<?php

namespace App\Models;

use App\Models\SellPostReaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
{
    return $this->hasMany(SellPostReaction::class, 'sell_post_id');
}

public function comments()
{
    return $this->hasMany(SellPostComment::class, 'sell_post_id')->with('user')->latest();
}
}
