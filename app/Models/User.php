<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model to represent a User
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use HasFactory, SoftDeletes;
    use HasRelationships;

    public const filterable = [
        'username' => StringOperators::class,
        'email' => StringOperators::class,
        'email_verified_at' => DateOperators::class,
        'lastname' => StringOperators::class,
        'firstname' => StringOperators::class,
        'nationality_id' => NumberOperators::class,
        'birthdate' => DateOperators::class,
        'address' => StringOperators::class,
        'postal_code' => StringOperators::class,
        'address_country_id' => NumberOperators::class,
        'phone' => StringOperators::class,
        'site_role_id' => NumberOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
        'deleted_at' => DateOperators::class,
        'last_login' => DateOperators::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'lastname',
        'firstname',
        'nationality_country_id',
        'birthdate',
        'address',
        'postal_code',
        'address_country_id',
        'phone',
        'picture',
        'site_role_id',
        'last_login'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthdate' => 'date',
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Returns the joined nationality Country
     *
     * @return BelongsTo
     */
    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'nationality_country_id');
    }

    /**
     * Returns the joined address Country
     *
     * @return BelongsTo
     */
    public function addressCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'address_country_id');
    }

    /**
     * Returns the joined SiteRole
     *
     * @return BelongsTo
     */
    public function siteRole(): BelongsTo
    {
        return $this->belongsTo(SiteRole::class);
    }

    /**
     * Returns all the related Course's where this user is a teacher.
     *
     * @return HasMany
     */
    public function teacherCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'teacher_user_id');
    }

    /**
     * Returns all the related CohortMember's
     *
     * @return HasMany
     */
    public function cohortMembers(): HasMany
    {
        return $this->hasMany(CohortMember::class)
            ->with('cohort');
    }

    /**
     * Returns all the related Enrollment's
     *
     * @return HasMany
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class)
            ->with('formation');
    }

    /**
     * Returns all the related Grade's
     *
     * @return HasMany
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class)
            ->with('course');
    }

    /**
     * Change the Site Role of the User.
     *
     * @param int $siteRole
     * @return void
     */
    public function changeSiteRole(int $siteRole) : void
    {
        $this->siteRole()->associate($siteRole)->save();
    }

    /**
     * Checks if the User Site Role is guest or null.
     *
     * @return bool
     */
    public function isGuestSiteRole(): bool
    {
        // users without roles are considered guests.
        return (!$this->siteRole || $this->siteRole->isGuest());
    }

    /**
     * Checks if the User Site Role is User.
     *
     * @return bool
     */
    public function isUserSiteRole(): bool
    {
        return $this->siteRole->isUser();
    }

    /**
     * Checks if the User Site Role is Secretary.
     *
     * @return bool
     */
    public function isSecretarySiteRole(): bool
    {
        return $this->siteRole->isSecretary();
    }

    /**
     * Checks if the User Site Role is Administrator.
     *
     * @return bool
     */
    public function isAdministratorSiteRole(): bool
    {
        return $this->siteRole->isAdministrator();
    }

    /**
     * Checks if the User Site Role is Banned.
     *
     * @return bool
     */
    public function isBannedSiteRole(): bool
    {
        return $this->siteRole->isBanned();
    }
}
