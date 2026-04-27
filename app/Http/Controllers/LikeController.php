<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct(private LikeService $likeService) {}

    public function store(string $id)
    {
        $post = $this->likeService->store($id, auth()->id());

        return response()->json([
            'message' => 'Post liked successfully',
            'liked' => true,
            'likes_count' => $post->likes()->count()
        ]);
    }

    public function destroy(string $id)
    {
        $post = $this->likeService->destroy($id, auth()->id());

        return response()->json([
            'message' => 'Post unliked successfully',
            'liked' => false,
            'likes_count' => $post->likes()->count()
        ]);
    }
}
