<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model to represent a Grade
 */
class Grade extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    public const filterable = [
        'score' => NumberOperators::class,
        'user_id' => NumberOperators::class,
        'course_id' => NumberOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
        'deleted_at' => DateOperators::class,
    ];

    protected $fillable = [
        'user_id',
        'course_id',
        'score'
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    // Default values.
    protected $attributes = [
        'score' => null,
    ];

    /**
     * Returns the joined User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the joined Course
     *
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
