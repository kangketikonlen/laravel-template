<?php

namespace App\Models\System;

use App\Models\System\Subnavbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Navbar extends Model
{
    use HasFactory;

    public function subnavbars()
    {
        return $this->hasMany(Subnavbar::class, 'navbar_id');
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
