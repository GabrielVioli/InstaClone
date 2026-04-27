<?php
namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $id = fake()->numberBetween(1, 1000);
        return [
            'user_id' => User::factory(),
            'image_path' => "https://picsum.photos/seed/{$id}/1080/1080",
            'caption' => fake()->paragraph(),
        ];
    }
}
