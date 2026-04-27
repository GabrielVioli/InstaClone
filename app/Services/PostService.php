<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class PostService
{
    public function store(array $validated, ?UploadedFile $image, User $user): Post
    {
        if ($image) {
            $path = $image->store('posts', 'public');
            $validated['image_path'] = $path;
        }

        return $user->posts()->create($validated)->load('user');
    }

    public function show(string $id): Post
    {
        return Post::with(['user', 'comments.user'])
            ->withCount(['likes', 'comments'])
            ->findOrFail($id);
    }

    public function update(Post $post, array $validated): Post
    {
        $post->update($validated);

        return $post->load('user');
    }

    public function destroy(Post $post): void
    {
        $post->delete();
    }
}
