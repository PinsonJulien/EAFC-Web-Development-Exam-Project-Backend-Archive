<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationCourse extends Model
{
    use HasFactory;

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
