<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UploadAvatarRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private UserService $userService) {}

    public function show($username)
    {
        $user = $this->userService->show($username);

        return new UserResource($user);
    }

    public function suggestions(Request $request)
    {
        $perPage = $request->input('per_page', 5);

        $suggestions = $this->userService->suggestions(auth()->id(), $perPage);

        return UserResource::collection($suggestions);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = $this->userService->search($query);

        return UserResource::collection($users);
    }

    public function updateMe(UpdateUserRequest $request)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $updatedUser = $this->userService->updateMe($user, $request->validated());

        return new UserResource($updatedUser);
    }

    public function uploadAvatar(UploadAvatarRequest $request)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $updatedUser = $this->userService->uploadAvatar($user, $request->file('avatar'));

        return new UserResource($updatedUser);
    }

    public function posts(string $id)
    {
        $posts = $this->userService->posts($id);

        return PostResource::collection($posts);
    }
}
