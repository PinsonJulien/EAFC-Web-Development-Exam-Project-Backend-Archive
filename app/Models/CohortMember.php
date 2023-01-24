<?php

namespace App\Models;

use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CohortMember extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    protected $fillable = [
        'user_id',
        'cohort_id',
        'cohort_role_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(CohortRole::class, 'cohort_role_id');
    }
}
