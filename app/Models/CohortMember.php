<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CohortMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cohort_id',
        'cohort_role_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cohort() {
        return $this->belongsTo(Cohort::class);
    }

    public function role() {
        return $this->belongsTo(CohortRole::class, 'cohort_role_id');
    }
}
