<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           // Assuming you already have some posts and categories in the database

        // Get all posts
        $posts = Post::all();

        // Get all categories
        $categories = Category::all();

        // Attach multiple categories to each post
        foreach ($posts as $post) {
            // Attach 2-3 random categories to each post
            $post->categories()->attach(
                $categories->random(rand(2, 3))->pluck('id')->toArray()
            );
        }
    }
}
