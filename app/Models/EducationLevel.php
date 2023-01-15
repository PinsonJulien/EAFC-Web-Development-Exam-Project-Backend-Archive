<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationLevel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function formations() {
        return $this->hasMany(Formation::class);
    }
}
