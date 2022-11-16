<?php

namespace Database\Factories\Blog;

use Illuminate\Support\Str;
use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $content = 'hình ảnh đc thêm vào nội dung bài viết phải đc lưu lại vào storage/s3';
        // --------------
        $name = fake()->sentence($nbWords = 15, $variableNbWords = true);
        $slug = Str::of($name)->slug('-');
        $description = fake()->sentence($nbWords = 5, $variableNbWords = true);
        $meta_title = fake()->sentence($nbWords = 5, $variableNbWords = true);
        $meta_description = fake()->sentence($nbWords = 5, $variableNbWords = true);
        $meta_keywords = fake()->sentence($nbWords = 1, $variableNbWords = true);
        return [
            'name' => $name,
            'slug' => $slug,
            'content' => $content,
            'description' => $description,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'publish_at' => now(),
            'is_authenticated' => false,
        ];
    }
    public function isAuthenticated()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_authenticated' => true,
            ];
        });
    }
}
