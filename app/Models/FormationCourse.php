<?php

namespace App\Models;

use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model to represent a FormationCourse
 */
class FormationCourse extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    protected $table = 'formations_courses';

    protected $fillable = [
      'formation_id',
      'course_id',
    ];

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
     * Returns the joined Course
     *
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
