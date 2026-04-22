<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Tenant extends Model
{
    /** @use HasFactory<\Database\Factories\TenantFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->uuid = Uuid::uuid4();

            if (!$model->slug) {
                $model->slug = str()->slug($model->name, "_");

                while (self::whereSlug($model->slug)->exists()) {
                    $model->slug = str()->slug($model->name, "_") . "_" . str()->random(5);
                }
            }
        });

        static::updating(function (Model $model) {
            if (!$model->slug) {
                $model->slug = str()->slug($model->name, "_");

                while (self::whereSlug($model->slug)->exists()) {
                    $model->slug = str()->slug($model->name, "_") . "_" . str()->random(5);
                }
            }
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
