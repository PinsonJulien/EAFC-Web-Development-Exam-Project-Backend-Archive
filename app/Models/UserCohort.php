<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCohort extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'group_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cohort() {
        return $this->belongsTo(Cohort::class);
    }
}
