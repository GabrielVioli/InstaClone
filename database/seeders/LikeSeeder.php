<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        foreach ($posts as $post) {
            $likers = $users->random(rand(0, 8));

            $post->likes()->attach($likers->pluck('id'));
        }
    }
}
