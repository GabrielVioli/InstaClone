<?php

namespace App\Services;

use App\Models\User;

class FollowService
{
    public function store(string $id, User $currentUser): void
    {
        $userToFollow = User::findOrFail($id);

        if ($userToFollow->id === $currentUser->id) {

            abort(422, 'You cannot follow yourself');
        }

        $currentUser->following()->syncWithoutDetaching([$userToFollow->id]);
    }

    public function destroy(string $id, User $currentUser): void
    {
        $userToUnfollow = User::findOrFail($id);

        $currentUser->following()->detach($userToUnfollow->id);
    }

    public function followers(string $id)
    {
        $user = User::findOrFail($id);

        return $user->followers()->paginate(20);
    }

    public function following(string $id)
    {
        $user = User::findOrFail($id);

        return $user->following()->paginate(20);
    }

    public function isFollowing(string $id, User $currentUser): bool
    {
        return $currentUser->following()->where('following_id', $id)->exists();
    }
}
