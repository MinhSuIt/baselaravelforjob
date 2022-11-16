<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog\Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->sentence($nbWords = 2, $variableNbWords = true);
        $slug = Str::of($name)->slug('-');
        $description = fake()->sentence($nbWords = 5, $variableNbWords = true);
        $meta_title = fake()->sentence($nbWords = 5, $variableNbWords = true);
        $meta_description = fake()->sentence($nbWords = 5, $variableNbWords = true);
        $meta_keywords = fake()->sentence($nbWords = 1, $variableNbWords = true);
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
        ];
    }
}
