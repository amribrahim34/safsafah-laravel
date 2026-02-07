<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeautyProfile extends Model
{
    protected $fillable = [
        'user_id',
        'skin_type_id',
        'allergies',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skinType()
    {
        return $this->belongsTo(SkinType::class);
    }
}
