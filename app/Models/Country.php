<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\StringOperators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    public const filterable = [
        'name' => StringOperators::class,
        'iso' => StringOperators::class,
    ];

    public $timestamps = false;

    protected $fillable = [
        'name',
        'iso'
    ];
}
