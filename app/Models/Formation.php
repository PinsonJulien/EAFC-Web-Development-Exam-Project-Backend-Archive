<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\BooleanOperators;
use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use App\Traits\Models\HasRelationships;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Formation extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    public const filterable = [
        'name' => StringOperators::class,
        'status' => BooleanOperators::class,
        'start_date' => DateOperators::class,
        'end_date' => DateOperators::class,
        'education_level_id' => NumberOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
        'deleted_at' => DateOperators::class,
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

    /**
     * Observe the Formation CRUD methods and perform actions accordingly.
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::deleting(function (Formation $formation) {
            // Cannot delete if there's existing cohorts.
            if ($formation->cohorts()->exists())
                throw new Exception("This formation cannot be deleted because it has Cohort relations.");

            // Delete all the FormationCourse entries.
            $formation->formationCourses()->delete();

            // Delete all the enrollments.
            $formation->enrollments()->delete();
        });
    }

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'formations_courses');
    }

    public function formationCourses(): HasMany
    {
        return $this->hasMany(FormationCourse::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class)->with('user');
    }

    public function cohorts(): HasMany
    {
        return $this->hasMany(Cohort::class);
    }

    /** Helpers methods. **/

    /**
     * Returns the cohort for this formation academic year.
     * If it doesn't exist, create it.
     * Every first september, a new one should be created.
     *
     * @return void
     */
    public function getCurrentAcademicYearCohort(): object
    {
        $now = Carbon::now();
        $currentAcademicYear = ($now->month >= 9) ? $now->year : $now->year - 1;
        $firstSeptember = Carbon::createFromDate($currentAcademicYear, 9, 1);

        // Try to get existing cohort for this academic year.
        $cohort = $this->cohorts()
            ->where('created_at', '>=', $firstSeptember->toDateTime())
            ->first();

        if ($cohort) return $cohort;

        // If it doesn't exist, create it, return it.
        $cohort = $this->cohorts()->create([
            'name' => $this->name . " ".$currentAcademicYear. " - ".$currentAcademicYear+1,
        ]);

        return $cohort;
    }
}
