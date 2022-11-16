<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->sentence($nbWords = 2, $variableNbWords = true) ;
        $slug = Str::of($name)->slug('-');
        $description = fake()->sentence($nbWords = 5, $variableNbWords = true) ;
        $meta_title = fake()->sentence($nbWords = 5, $variableNbWords = true) ;
        $meta_description = fake()->sentence($nbWords = 5, $variableNbWords = true) ;
        $meta_keywords = fake()->sentence($nbWords = 1, $variableNbWords = true) ;
        return [
            'name' => $name,
            'position' => 0,
            'slug' => $slug,
            'description' => $description,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'status' => true,
        ];
    }
}
