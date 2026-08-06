<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellPostReaction extends Model
{
use HasFactory;

    // Database ထဲက Table နာမည်အမှန်ကို သတ်မှတ်ပေးပါ
    protected $table = 'post_reactions';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sellPost()
    {
        return $this->belongsTo(SellPost::class);
    }
}
