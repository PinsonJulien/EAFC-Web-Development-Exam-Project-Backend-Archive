<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cohort extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function users() {
        // todo delete users().
        return $this->belongsToMany(User::class, 'users_cohorts');
    }

    public function members() {
        // todo return members { user, cohortRole }
    }
}
