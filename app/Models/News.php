<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['title', 'description', 'writer', 'news-img', 'view_count'];
    public $timestamps = false;
    use HasFactory;

    public function comments(): HasMany
    {
        return $this->hasMany(NewsComment::class, 'news_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(NewsReaction::class, 'news_id');
    }
}
