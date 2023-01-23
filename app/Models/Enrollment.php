<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\NumberOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use HasFactory, SoftDeletes;

    public const relationMethods = [];

    public const filterable = [
        'message' => StringOperators::class,
        'status_id' => NumberOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
    ];

    protected $fillable = [
        'user_id',
        'formation_id',
        'message',
        'status_id'
    ];

    // Default values.
    protected $attributes = [
        'message' => null,
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function formation() {
        return $this->belongsTo(Formation::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }
}
