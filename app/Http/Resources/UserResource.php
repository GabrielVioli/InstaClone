<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $avatarPath = $this->avatar;
        $avatarUrl = '';

        if ($avatarPath) {
            if (Str::startsWith($avatarPath, ['http://', 'https://'])) {
                $avatarUrl = $avatarPath;
            } else {
                $avatarUrl = url(Storage::url($avatarPath));
            }
        }

        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'username' => $this->username,
            'email'    => $this->email,
            'avatar_url' => $avatarUrl,
            'bio'      => $this->bio,
            'created_at' => $this->created_at,
            'joined_at' => $this->created_at->format('d/m/Y'),
            'posts_count'     => $this->whenCounted('posts'),
            'followers_count' => $this->whenCounted('followers'),
            'following_count' => $this->whenCounted('following'),
        ];
    }
}
