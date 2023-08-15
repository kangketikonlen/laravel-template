<?php

namespace App\Models;

use App\Models\System\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->createdAt = $model->freshTimestamp();
            $model->createdBy = auth()->check() ? auth()->user()->name : "System";
        });

        static::updating(function ($model) {
            $model->updatedAt = $model->freshTimestamp();
            $model->updatedBy = auth()->check() ? auth()->user()->name : "System";
        });
    }
}
