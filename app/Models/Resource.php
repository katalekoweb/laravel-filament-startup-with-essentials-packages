<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'unit_resources');
    }
}
