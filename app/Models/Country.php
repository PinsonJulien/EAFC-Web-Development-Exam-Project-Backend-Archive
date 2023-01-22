<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\StringOperators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    public const relationMethods = ['nationalityUsers', 'addressUsers'];

    public const filterable = [
        'name' => StringOperators::class,
        'iso' => StringOperators::class,
    ];

    protected $fillable = [
        'name',
        'iso'
    ];

    public function nationalityUsers() {
        return $this->hasMany(User::class, 'nationality_country_id');
    }

    public function addressUsers() {
        return $this->hasMany(User::class, 'address_country_id');
    }
}
