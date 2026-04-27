<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'username' => $this->username,
            'email'    => $this->email,
            'avatar'   => $this->avatar,
            'bio'      => $this->bio,
            'joined_at' => $this->created_at->format('d/m/Y'),
            'posts_count'     => $this->whenCounted('posts'),
            'followers_count' => $this->whenCounted('followers'),
            'following_count' => $this->whenCounted('following'),
        ];
    }
}
