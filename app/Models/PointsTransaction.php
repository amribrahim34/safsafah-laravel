<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointsTransaction extends Model
{
    public $timestamps = false; // Because migration only has created_at default current timestamp, no updated_at

    protected $fillable = [
        'user_id',
        'points',
        'transaction_type',
        'source',
        'reference_id',
        'description',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
