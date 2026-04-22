<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, BelongsToTenant, HasFactory;

    protected $guarded = [];

    public function ocupant () : BelongsTo {
        return $this->belongsTo(User::class, 'ocupant_id');
    }

    public function unit () : BelongsTo {
        return $this->belongsTo(Unit::class);
    }
}
