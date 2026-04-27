<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            Post::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
