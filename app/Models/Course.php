<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\BooleanOperators;
use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model to represent a Course
 */
class Course extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    public const filterable = [
        'name' => StringOperators::class,
        'status' => BooleanOperators::class,
        'teacher_user_id' => NumberOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
        'deleted_at' => DateOperators::class,
    ];

    protected $fillable = [
        'name',
        'status',
        'teacher_user_id'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * Returns the joined teacher
     *
     * @return BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    /**
     * Returns all the related Formation's
     *
     * @return BelongsToMany
     */
    public function formations(): BelongsToMany
    {
        return $this->belongsToMany(Formation::class, 'formations_courses');
    }

    /**
     * Returns all the related Grade's
     *
     * @return HasMany
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class)
            ->with('user');
    }
}
