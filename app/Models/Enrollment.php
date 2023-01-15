<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use HasFactory, SoftDeletes;

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
