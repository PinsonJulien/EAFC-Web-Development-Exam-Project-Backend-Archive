<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use App\Traits\Models\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model to represent a Country
 */
class Country extends Model
{
    use HasFactory, SoftDeletes;
    use HasRelationships;

    public const filterable = [
        'name' => StringOperators::class,
        'iso' => StringOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
        'deleted_at' => DateOperators::class,
    ];

    protected $fillable = [
        'name',
        'iso'
    ];

    /**
     * Returns all the related Users who have this country as their nationality
     *
     * @return HasMany
     */
    public function nationalityUsers(): HasMany
    {
        return $this->hasMany(User::class, 'nationality_country_id');
    }

    /**
     * Returns all the related Users who have this country as their address
     *
     * @return HasMany
     */
    public function addressUsers(): HasMany
    {
        return $this->hasMany(User::class, 'address_country_id');
    }
}
