<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function show(string $username): User
    {
        return User::where('username', $username)
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();
    }

    public function suggestions(int $authUserId, int $perPage)
    {
        return User::where('id', '!=', $authUserId)
            ->whereDoesntHave('followers', function($query) use ($authUserId) {
                $query->where('follower_id', $authUserId);
            })
            ->withCount(['posts', 'followers', 'following'])
            ->inRandomOrder()
            ->paginate($perPage);
    }

    public function search(?string $query)
    {
        return User::where('username', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->paginate(20);
    }

    public function updateMe(User $user, array $validated): User
    {
        $user->update($validated);

        return $user;
    }

    public function uploadAvatar(User $user, UploadedFile $avatar): User
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $avatar->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return $user;
    }

    public function posts(string $id)
    {
        $user = User::findOrFail($id);

        return $user->posts()
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(15);
    }
}
