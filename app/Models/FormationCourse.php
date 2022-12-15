<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormationCourse extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
      'formation_id',
      'course_id',
    ];

    public function formation() {
        return $this->belongsTo(Formation::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
