<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    // Constants
    public const PENDING = 1;
    public const APPROVED = 2;
    public const DENIED = 3;
    public const CANCELLED = 4;
    public const EXPIRED = 5;
    public const SUSPENDED = 6;

    protected $table = 'statuses';

    public const relationMethods = ['enrollments',];

    public const filterable = [
        'name' => StringOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
    ];

    protected $fillable = [
        'name',
    ];

    public function enrollments() {
        return $this->hasMany(Enrollment::class)
            ->with(['user', 'formation']);
    }
}
