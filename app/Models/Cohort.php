<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;

class Cohort extends Model
{
    use HasFactory,  SoftDeletes;

    public const relationMethods = ['members',];

    public const filterable = [
        'name' => StringOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
    ];

    protected $fillable = [
        'name',
    ];

    public function members() {
        return $this->hasMany(CohortMember::class);
    }
}
