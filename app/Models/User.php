<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Define tenant_id se estiver logado
            if (Auth::check() && !isset($model->tenant_id)) {
                $model->tenant_id = Auth::user()->tenant_id;
            }

            // Define created_by / user_id se existir
            if (Auth::check() && !isset($model->user_id)) {
                $model->user_id = Auth::id();
            }

            // Gera UUID automaticamente
            if (empty($model->uuid) && !isset($model->uuid)) {
                $model->uuid = (string) Uuid::uuid4();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'tenant_id',
        'email',
        'password',
        'type', 'phone', 'address', 'photo',
        'phone2', 'doc_front_image', 'doc_verse_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean'
        ];
    }

    public function tenant () {
        return $this->belongsTo(Tenant::class);
    }
}
