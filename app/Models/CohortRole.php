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
 * Model to represent a CohortRole
 */
class CohortRole extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    // Constants of all roles.
    public const STUDENT = 1;
    public const ASSISTANT = 2;
    public const TEACHER = 3;

    public const filterable = [
        'name' => StringOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
        'deleted_at' => DateOperators::class,
    ];

    protected $fillable = [
        'name',
    ];

    /**
     * Returns all the related CohortMember's
     *
     * @return HasMany
     */
    public function cohortMembers(): HasMany
    {
        return $this->hasMany(CohortMember::class)
            ->with(['cohort', 'user']);
    }

}
