<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
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
        return $user->isSecretarySiteRole() || $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Status $status
     * @return bool
     */
    public function view(User $user, Status $status): bool
    {
        return $user->isSecretarySiteRole() || $user->isAdministratorSiteRole();
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
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Status $status
     * @return bool
     */
    public function update(User $user, Status $status): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Status $status
     * @return bool
     */
    public function delete(User $user, Status $status): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Status $status
     * @return bool
     */
    public function restore(User $user, Status $status): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Status $status
     * @return bool
     */
    public function forceDelete(User $user, Status $status): bool
    {
        return $user->isAdministratorSiteRole();
    }
}
