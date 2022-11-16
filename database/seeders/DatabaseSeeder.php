<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Blog\Category;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(5)->create();
        Tag::factory(5)->create();
        Post::factory(1)->create();
        Post::factory()->isAuthenticated()->create()->each(function ($post, $key) {
            $url = 'https://fakeimg.pl/250x100/';
            $post
                ->addMediaFromUrl($url)
                ->toMediaCollection('thumbnail');
        });
        User::factory(10)->create();
        User::factory(1)->create([
            'email'=>"minhsudoit@gmail.com",
            'password'=>Hash::make("minhsudoit@gmail.com"),
        ]);




        // ----------

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
