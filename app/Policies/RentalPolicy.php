<?php

namespace App\Policies;

use App\Models\Rental;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RentalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Rental $rental): bool
    {
        return $user->id === $rental->renter_id || $user->id === optional($rental->equipment)->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
		return $user->hasRole(['producer', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Rental $rental): bool
    {
        return $user->id === optional($rental->equipment)->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Rental $rental): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Rental $rental): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Rental $rental): bool
    {
        return $user->hasRole('admin');
    }
}
