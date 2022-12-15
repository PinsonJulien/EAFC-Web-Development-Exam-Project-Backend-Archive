<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'start_date',
        'end_date',
        'education_level_id',
    ];

    public function educationLevel() {
        return $this->belongsTo(EducationLevel::class);
    }

    public function courses() {
        return $this->belongsToMany(Course::class, 'formation_courses');
    }
}
