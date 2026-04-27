<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;

class CommentService
{
    public function index(string $id)
    {
        $post = Post::findOrFail($id);

        return $post->comments()
            ->with('user')
            ->latest()
            ->paginate(10);
    }

    public function store(string $id, int $userId, string $content): Comment
    {
        $post = Post::findOrFail($id);

        $comment = $post->comments()->create([
            'user_id' => $userId,
            'content' => $content,
        ]);

        return $comment->load('user');
    }

    public function destroy(string $id): void
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }
}
