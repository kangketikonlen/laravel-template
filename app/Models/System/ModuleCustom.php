<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class ModuleCustom extends Model
{
    use HasFactory;

    public function moduleCustomUsers(): HasMany
    {
        return $this->hasMany(ModuleCustomUser::class, 'module_custom_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->createdAt = $model->freshTimestamp();
            $model->createdBy = Auth::check() ? session('name') : "System";
        });

        static::updating(function ($model) {
            $model->updatedAt = $model->freshTimestamp();
            $model->updatedBy = Auth::check() ? session('name') : "System";
        });
    }
}
