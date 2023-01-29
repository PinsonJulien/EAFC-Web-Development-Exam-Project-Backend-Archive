<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Str;

class UserPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
        return true;
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
     * Determine whether the user can export the model
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function export(User $user, User $model): bool
    {
        $isModelOwned = ($user->id == $model->id);
        // Users can export their own data.
        return $isModelOwned || $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // Only administrators can create accounts with a base role.
        if (!$user->isAdministratorSiteRole() && request()->has(Str::camel('site_role_id')))
            return false;

        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        $isModelOwned = ($user->id == $model->id);

        // If the user is the same as the updated model, don't allow to update its own role.
        if ($isModelOwned && request()->has(Str::camel('site_role_id')))
            return false;

        // If the user is not the same as the update model, don't allow to update the password.
        if (!$isModelOwned && request()->has('password'))
            return false;

        // The owner can update their own information
        return $isModelOwned || $user->isSecretarySiteRole() || $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function delete(User $user, User $model): bool
    {
        $isModelOwned = ($user->id == $model->id);
        // Users can only delete their own account if they're guest.
        return ($isModelOwned  && $user->isGuestSiteRole()) || $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->isAdministratorSiteRole();
    }
}
