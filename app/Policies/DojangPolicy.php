<?php

namespace App\Policies;

use App\Models\Dojang;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DojangPolicy
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
    public function view(User $user, Dojang $dojang): bool
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
    public function update(User $user, Dojang $dojang): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dojang $dojang): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Dojang $dojang): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Dojang $dojang): bool
    {
        return $user->hasRole('admin');
    }
}
