<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkinConcern extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        });
    }
}
