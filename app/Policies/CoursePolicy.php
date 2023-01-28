<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\SiteRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CoursePolicy
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
        // Everyone can see courses.
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Course $course
     * @return bool
     */
    public function view(User $user, Course $course): bool
    {
        // Everyone can see courses.
        return true;
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
     * @param Course $course
     * @return bool
     */
    public function update(User $user, Course $course): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Course $course
     * @return bool
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Course $course
     * @return bool
     */
    public function restore(User $user, Course $course): bool
    {
        return $user->isAdministratorSiteRole();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Course $course
     * @return bool
     */
    public function forceDelete(User $user, Course $course): bool
    {
        return $user->isAdministratorSiteRole();
    }
}
