<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Text;
use Illuminate\Auth\Access\HandlesAuthorization;

class TextPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_text');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Text $text): bool
    {
        return $user->can('view_text');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_text');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Text $text): bool
    {
        return $user->can('update_text');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Text $text): bool
    {
        return $user->can('delete_text');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_text');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Text $text): bool
    {
        return $user->can('force_delete_text');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_text');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Text $text): bool
    {
        return $user->can('restore_text');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_text');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Text $text): bool
    {
        return $user->can('replicate_text');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_text');
    }
}
