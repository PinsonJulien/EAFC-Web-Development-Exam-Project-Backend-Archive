<?php

namespace App\Models;

use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use Illuminate\Support\Collection;

class Cohort extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    public const filterable = [
        'name' => StringOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
        'deleted_at' => DateOperators::class,
    ];

    protected $fillable = [
        'name',
        'formation_id'
    ];

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function cohortMembers(): HasMany
    {
        return $this->hasMany(CohortMember::class)
            ->with(['user']);
    }

    // Helpers Method

    /**
     * Find a CohortMember by a User
     * Usages: Look if the User exists in a Cohort.
     *
     * @param User|int $user
     * @return object|null
     */
    public function findCohortMemberByUser(User|int $user): object|null
    {
        $userId = $user->id ?? $user;
        return $this->cohortMembers()
            ->where('user_id', $userId)->first();
    }

    /**
     * Returns all the students of the cohort.
     *
     * @return Collection
     */
    public function getStudents(): Collection
    {
        return $this->cohortMembers()
            ->where('cohort_role_id', CohortRole::STUDENT)
            ->with('user')
            ->get();
    }
}
