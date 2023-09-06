<?php

namespace App\Models;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = [
        'id',
        'user_id'
    ];

    public function toArray()
    {
        $data = parent::toArray();

        $categories = $this->categories->map(function ($category) {
            return [
                'title' => $category->title,
                'slug' => $category->slug,
            ];
        });

        $data['categories'] = $categories->toArray();

        return $data;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = $post->generateUniqueSlug($post->title);
        });

        static::updating(function ($post) {
            $post->slug = $post->generateUniqueSlug($post->title);
        });
    }

    public function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = static::where('slug', $slug)->count();

        if ($count > 0) {
            do {
                $slug = Str::slug($title) . '-' . ($count + 1);
                $count++;
            } while (static::where('slug', $slug)->count() > 0);
        }

        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories');
    }
}