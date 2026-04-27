<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\FollowService;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __construct(private FollowService $followService) {}

    public function store(string $id, Request $request)
    {
        $this->followService->store($id, $request->user());

        return response()->json(['message' => 'User followed successfully']);
    }

    public function destroy(string $id, Request $request)
    {
        $this->followService->destroy($id, $request->user());

        return response()->json(['message' => 'User unfollowed successfully']);
    }

    public function followers(string $id)
    {
        $followers = $this->followService->followers($id);

        return UserResource::collection($followers);
    }

    public function following(string $id)
    {
        $following = $this->followService->following($id);

        return UserResource::collection($following);
    }

    public function isFollowing(string $id, Request $request)
    {
        $isFollowing = $this->followService->isFollowing($id, $request->user());

        return response()->json(['is_following' => $isFollowing]);
    }
}
