<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{


    /**
     * Determine whether the user can permanently delete the model.
     */
    public function modify(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id || $user->id === $comment->post->user_id
            ? Response::allow()
            : Response::deny("You cannot complish this action");
    }
}
