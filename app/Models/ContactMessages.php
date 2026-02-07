<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessages extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'mobile',
        'message',
        'file',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        });
    }
}
