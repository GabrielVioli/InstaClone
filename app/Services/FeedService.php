<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class FeedService
{
    public function index(User $user)
    {
        $followingIds = $user->following()->pluck('following_id');

        $userIds = $followingIds->push($user->id);

        return Post::whereIn('user_id', $userIds)
            ->with(['user', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->cursorPaginate(10);
    }
}
