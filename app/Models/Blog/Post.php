<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $with = ['media'];
    protected $fillable = [
        'name',
        'slug',
        'content',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'publish_at',
        'is_authenticated',
    ];

    protected $attributes = [
        'name' => '',
        'slug' => '',
        'content' => '',
        'description' => '',
        'meta_title' => '',
        'meta_description' => '',
        'meta_keywords' => '',
        'publish_at' => null,
        'is_authenticated' => false,
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }
}
