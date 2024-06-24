<?php

namespace App\Policies;

use App\Models\BlogComment;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogCommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['Admin', 'Author', 'Moderator', 'User']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BlogComment $comment): bool
    {
        return in_array($user->role, ['Admin', 'Moderator', 'Author']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['Admin', 'Author', 'Moderator', 'User']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BlogComment $comment): bool
    {
        return in_array($user->role, ['Admin', 'Author', 'Moderator']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BlogComment $comment): bool
    {
        return $user->id === $comment->user_id || $user->isAdmin() || $user->isModerator() || $user->isAuthor();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BlogComment $comment): bool
    {
        return $user->id === $comment->user_id || $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BlogComment $comment): bool
    {
        return $user->isAdmin();
    }
}
