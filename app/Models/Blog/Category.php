<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'position' => 0,
        'slug' => '',
        'description' => '',
        'meta_title' => '',
        'meta_description' => '',
        'meta_keywords' => '',
        'status' => true,
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
