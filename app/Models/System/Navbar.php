<?php

namespace App\Models\System;

use App\Models\System\Subnavbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Navbar extends Model
{
    use HasFactory;

    public function subnavbars(): HasMany
    {
        return $this->hasMany(Subnavbar::class, 'navbar_id');
    }

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
