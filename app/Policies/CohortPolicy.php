<?php

namespace App\Policies;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Policy for the Cohort model
 */
class CohortPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        // Everyone except : Guests
        return !$user->isGuestSiteRole();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Cohort $cohort
     * @return bool
     */
    public function view(User $user, Cohort $cohort): bool
    {
        // Everyone except : Guests
        return !$user->isGuestSiteRole();
    }

    /**
     * Determine whether the user can export any models.
     *
     * @param User $user
     * @return bool
     */
    public function exportAny(User $user): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isSecretarySiteRole() || $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Cohort $cohort
     * @return bool
     */
    public function update(User $user, Cohort $cohort): bool
    {
        return $user->isSecretarySiteRole() || $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Cohort $cohort
     * @return bool
     */
    public function delete(User $user, Cohort $cohort): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Cohort $cohort
     * @return bool
     */
    public function restore(User $user, Cohort $cohort): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Cohort $cohort
     * @return bool
     */
    public function forceDelete(User $user, Cohort $cohort): bool
    {
        return $user->isAdministratorSiteRole();
    }
}
