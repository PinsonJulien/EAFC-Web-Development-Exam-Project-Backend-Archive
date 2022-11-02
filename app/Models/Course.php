<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'user_id'
    ];

    public function teacher() {
        return $this->belongsTo(User::class);
    }

    public function formations() {
        return $this->belongsToMany(Formation::class, 'formation_courses');
    }
}
