<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */

    use HasFactory, SoftDeletes, BelongsToTenant;
    protected $guarded = [];

    protected $casts = [
        //'sell_price' => 'decimal:2',
        //'month_rent_price' => 'decimal:2',
        //'daily_rent_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'unit_resources');
    }

    protected function sellPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value): mixed {
                $value = formatCurrency((float) $value);
                return $value;
            },
            set: function ($value) {
                // clean money
                $value = cleanMoney($value);
                return (float) $value;
            }
        );
    }

    protected function monthRentPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value): mixed {
                $value = formatCurrency((float) $value);
                return $value;
            },
            set: function ($value) {
                // clean money
                $value = cleanMoney($value);
                return (float) $value;
            }
        );
    }

    protected function dailyRentPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value): mixed {
                $value = formatCurrency((float) $value);
                return $value;
            },
            set: function ($value) {
                // clean money
                $value = cleanMoney($value);
                return (float) $value;
            }
        );
    }
}
