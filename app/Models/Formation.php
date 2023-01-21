<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\BooleanOperators;
use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formation extends Model
{
    use HasFactory, SoftDeletes;

    public const relationMethods = ['courses', 'enrollments',];

    public const filterable = [
        'name' => StringOperators::class,
        'status' => BooleanOperators::class,
        'start_date' => DateOperators::class,
        'end_date' => DateOperators::class,
        'education_level_id' => NumberOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
    ];

    protected $fillable = [
        'name',
        'status',
        'start_date',
        'end_date',
        'education_level_id',
    ];

    protected $casts = [
        'status' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function educationLevel() {
        return $this->belongsTo(EducationLevel::class);
    }

    public function courses() {
        return $this->belongsToMany(Course::class, 'formations_courses');
    }

    public function enrollments() {
        return $this->hasMany(Enrollment::class)->with('user');
    }
}
