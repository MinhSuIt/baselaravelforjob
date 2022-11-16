<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'slug' => '',
        'description' => '',
        'meta_title' => '',
        'meta_description' => '',
        'meta_keywords' => '',
    ];

    public function scopeId($query, $id)
    {
        $query->where('id', $id);
    }
    public function scopeName($query, $name)
    {
        $query->where('name', "like", "%$name%");
    }
}
