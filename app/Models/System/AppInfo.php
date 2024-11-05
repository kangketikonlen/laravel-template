<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AppInfo extends Model
{
    use HasFactory;

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
