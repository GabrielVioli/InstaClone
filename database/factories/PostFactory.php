<?php
namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'image_path' => fake()->imageUrl(1080, 1080, 'animals', true),
            'caption' => fake()->paragraph(),
        ];
    }
}
