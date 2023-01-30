<?php

namespace App\Providers;

use App\Models\Cohort;
use App\Models\CohortMember;
use App\Models\CohortRole;
use App\Models\Country;
use App\Models\Course;
use App\Models\EducationLevel;
use App\Models\Enrollment;
use App\Models\Formation;
use App\Models\FormationCourse;
use App\Models\Grade;
use App\Models\SiteRole;
use App\Models\Status;
use App\Models\User;
use App\Policies\CohortMemberPolicy;
use App\Policies\CohortPolicy;
use App\Policies\CountryPolicy;
use App\Policies\CoursePolicy;
use App\Policies\EducationLevelPolicy;
use App\Policies\EnrollmentPolicy;
use App\Policies\FormationPolicy;
use App\Policies\GradePolicy;
use App\Policies\SiteRolePolicy;
use App\Policies\StatusPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        CohortMember::class => CohortMemberPolicy::class,
        Cohort::class => CohortPolicy::class,
        CohortRole::class => CohortRole::class,
        Country::class => CountryPolicy::class,
        Course::class => CoursePolicy::class,
        EducationLevel::class => EducationLevelPolicy::class,
        Enrollment::class => EnrollmentPolicy::class,
        Formation::class => FormationPolicy::class,
        FormationCourse::class => FormationCourse::class,
        Grade::class => GradePolicy::class,
        SiteRole::class => SiteRolePolicy::class,
        Status::class => StatusPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });*/
    }
}
