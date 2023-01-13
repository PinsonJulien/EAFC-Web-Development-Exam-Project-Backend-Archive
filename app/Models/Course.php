<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'teacher_user_id'
    ];

    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    public function formations() {
        return $this->belongsToMany(Formation::class, 'formations_courses');
    }
}
