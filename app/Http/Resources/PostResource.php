<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        $imagePath = $this->image_path;
        $imageUrl = '';

        if ($imagePath) {
            if (Str::startsWith($imagePath, ['http://', 'https://'])) {
                $imageUrl = $imagePath;
            } else {
                $imageUrl = url(Storage::url($imagePath));
            }
        }

        return [
            'id' => $this->id,
            'image_url' => $imageUrl,
            'caption' => $this->caption,
            'user' => new UserResource($this->whenLoaded('user')),
            'likes_count' => $this->whenCounted('likes'),
            'comments_count' => $this->whenCounted('comments'),
            'liked_by_me' => $this->when(auth()->check(), function () {
                return auth()->user()->likedPosts()->where('post_id', $this->id)->exists();
            }),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
