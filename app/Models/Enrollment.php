<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model to represent a Enrollment
 */
class Enrollment extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    public const filterable = [
        'message' => StringOperators::class,
        'status_id' => NumberOperators::class,
        'formation_id' => NumberOperators::class,
        'user_id' => NumberOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
        'deleted_at' => DateOperators::class,
    ];

    protected $fillable = [
        'user_id',
        'formation_id',
        'message',
        'status_id'
    ];

    // Default values.
    protected $attributes = [
        'message' => null,
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
     * Returns the joined Formation
     *
     * @return BelongsTo
     */
    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    /**
     * Returns the joined Status
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
