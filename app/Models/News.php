<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class News extends Model
{
    protected $table= 'news';
    protected $fillable = ['title', 'description','writer'];
    public $timestamps = false;
    use HasFactory;
}
