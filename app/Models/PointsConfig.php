<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointsConfig extends Model
{
    protected $fillable = [
        'rule_name',
        'rule_value',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
