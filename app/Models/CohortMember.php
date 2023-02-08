<?php

namespace App\Models;

use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * Model to represent a CohortMember
 */
class CohortMember extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    protected $fillable = [
        'user_id',
        'cohort_id',
        'cohort_role_id',
    ];

    /**
     * Returns the joined User.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the joined Cohort.
     *
     * @return BelongsTo
     */
    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class);
    }

    /**
     * Returns the joined Role.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(CohortRole::class, 'cohort_role_id');
    }
}
