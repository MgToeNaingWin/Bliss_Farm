<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellPostComment extends Model
{
    use HasFactory;
    protected $table = 'post_comments';

    // Database ထဲက Table နာမည်အမှန်ကို သတ်မှတ်ပေးပါ
    protected $fillable = ['sell_post_id', 'user_id', 'parent_id', 'comment'];

    // User Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Comment တစ်ခုအောက်ရှိ Replies များကို ခေါ်ယူရန်
    public function replies()
    {
        return $this->hasMany(SellPostComment::class, 'parent_id')->orderBy('created_at', 'asc');
    }
}
