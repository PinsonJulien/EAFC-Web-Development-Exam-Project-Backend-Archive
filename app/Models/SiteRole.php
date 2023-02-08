<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model to represent a SiteRole
 */
class SiteRole extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    // Constants of all roles.
    public const GUEST = 1;
    public const USER = 2;
    public const SECRETARY = 3;
    public const ADMINISTRATOR = 4;
    public const BANNED = 5;

    public const filterable = [
        'name' => StringOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
        'deleted_at' => DateOperators::class,
    ];

    protected $fillable = [
        'name',
    ];

    /** Relation methods */

    /**
     * Returns all the related User's
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /** Helper methods */

    /**
     * Determine if this role is Guest.
     *
     * @return bool
     */
    public function isGuest(): bool
    {
        return $this->id === self::GUEST;
    }

    /**
     * Determine if this role is User.
     *
     * @return bool
     */
    public function isUser(): bool {
        return $this->id === self::USER;
    }

    /**
     * Determine if this role is Secretary
     *
     * @return bool
     */
    public function isSecretary(): bool {
        return $this->id === self::SECRETARY;
    }

    /**
     * Determine if this role is Administrator
     *
     * @return bool
     */
    public function isAdministrator(): bool {
        return $this->id === self::ADMINISTRATOR;
    }

    /**
     * Determine if this role is Banned
     *
     * @return bool
     */
    public function isBanned(): bool {
        return $this->id === self::BANNED;
    }
}
