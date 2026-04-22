<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    /**
     * Boot the trait.
     */
    public static function bootBelongsToTenant()
    {
        static::creating(function ($model) {
            // Define tenant_id se estiver logado
            if (Auth::check() && !($model->tenant_id)) {
                $model->tenant_id = Auth::user()?->tenant_id;
            }

            // Define created_by / user_id se existir
            if (Auth::check() && !($model->user_id)) {
                $model->user_id = Auth::id();
            }

            // Gera UUID automaticamente
            if (empty($model->uuid) && !($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            if (Auth::user()?->tenant_id) $builder->where('tenant_id', Auth::user()?->tenant_id);
        });

    }

    /**
     * Scope para filtrar apenas registros do tenant logado.
     */
    public function scopeTenant($query)
    {
        if (Auth::check() and Auth::user()?->tenant_id) {
            return $query->where('tenant_id', Auth::user()->tenant_id);
        }

        // Se não estiver logado, retorna query sem filtro
        return $query;
    }

    public function tenant () {
        return $this->belongsTo(Tenant::class);
    }
}
