<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class BeautyProfile extends Model
{
    use HasFactory;
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

    public function skinConcerns()
    {
        return $this->belongsToMany(SkinConcern::class, 'beauty_profile_relations', 'user_id', 'related_id', 'user_id', 'id')
                    ->wherePivot('relation_type', 'skin_concern');
    }

    public function preferredIngredients()
    {
        return $this->belongsToMany(ActiveIngredient::class, 'beauty_profile_relations', 'user_id', 'related_id', 'user_id', 'id')
                    ->wherePivot('relation_type', 'preferred_ingredient');
    }

    public function avoidedIngredients()
    {
         return $this->belongsToMany(ActiveIngredient::class, 'beauty_profile_relations', 'user_id', 'related_id', 'user_id', 'id')
                    ->wherePivot('relation_type', 'avoided_ingredient');
    }
}
