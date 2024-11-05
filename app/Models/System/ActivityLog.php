<?php

namespace App\Models\System;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::check() ? session('name') : "System";
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::check() ? session('name') : null;
        });
    }
}
