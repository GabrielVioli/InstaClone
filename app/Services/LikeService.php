<?php

namespace App\Services;

use App\Models\Post;

class LikeService
{
    public function store(string $id, int $userId): Post
    {
        $post = Post::findOrFail($id);
        $post->likes()->syncWithoutDetaching([$userId]);

        return $post;
    }

    public function destroy(string $id, int $userId): Post
    {
        $post = Post::findOrFail($id);
        $post->likes()->detach($userId);

        return $post;
    }
}
