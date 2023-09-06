<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
