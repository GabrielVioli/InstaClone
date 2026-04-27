<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $toFollow = $users->where('id', '!=', $user->id)->random(rand(1, 5));

            $user->following()->attach($toFollow->pluck('id'));
        }
    }
}
