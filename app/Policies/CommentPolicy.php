<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // O dono do comentário pode deletar
        // OU o dono do post onde o comentário está pode deletar
        return $user->id === $comment->user_id || $user->id === $comment->post->user_id;
    }
}
