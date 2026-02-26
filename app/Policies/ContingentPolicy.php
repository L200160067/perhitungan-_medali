<?php

namespace App\Policies;

use App\Models\Contingent;
use App\Models\User;

class ContingentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'panitia']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contingent $contingent): bool
    {
        return $user->hasRole(['admin', 'panitia']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contingent $contingent): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contingent $contingent): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contingent $contingent): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contingent $contingent): bool
    {
        return $user->hasRole('admin');
    }
}
