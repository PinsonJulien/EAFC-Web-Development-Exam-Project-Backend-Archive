<?php

namespace App\Models;

use App\Helpers\Operators\CombinedOperators\DateOperators;
use App\Helpers\Operators\CombinedOperators\StringOperators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteRole extends Model
{
    use HasFactory, SoftDeletes;

    public const relationMethods = ['users',];

    public const filterable = [
        'name' => StringOperators::class,
        'created_at' => DateOperators::class,
        'updated_at' => DateOperators::class,
    ];

    protected $fillable = [
        'name',
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    // Constants of all roles.
    public const USER = 1;
    public const SECRETARY = 2;
    public const ADMINISTRATOR = 3;

    public function isUser(): bool {
        return $this->id === self::USER;
    }

    public function isSecretary(): bool {
        return $this->id === self::SECRETARY;
    }

    public function isAdministrator(): bool {
        return $this->id === self::ADMINISTRATOR;
    }
}
