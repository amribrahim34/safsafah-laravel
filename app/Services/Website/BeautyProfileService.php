<?php

namespace App\Services\Website;

use App\Models\ActiveIngredient;
use App\Models\BeautyProfile;
use App\Models\SkinConcern;
use App\Models\SkinType;
use Illuminate\Support\Facades\DB;

class BeautyProfileService
{
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }
    /**
     * Create a new class instance.
     */
    public function storeProfile(array $data)
    {
        // Update user skin type
        $profile = BeautyProfile::updateOrCreate(
            ['user_id' => $this->user->id],
            ['skin_type_id' => $data['skinTypeId'], 'allergies' => $data['allergies'] ?? null]
        );

        // Sync Relations in beauty_profile_relations table
        // We need to adhere to the schema: user_id, related_id, relation_type
        
        // Clear existing relations for this user to avoid duplicates if updating
        DB::table('beauty_profile_relations')->where('user_id', $this->user->id)->delete();

        $relations = [];
        $now = now();

        if (isset($data['skinConcernIds'])) {
            foreach ($data['skinConcernIds'] as $id) {
                $relations[] = [
                    'user_id' => $this->user->id,
                    'related_id' => $id,
                    'relation_type' => 'skin_concern',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (isset($data['preferredIngredientIds'])) {
            foreach ($data['preferredIngredientIds'] as $id) {
                $relations[] = [
                    'user_id' => $this->user->id,
                    'related_id' => $id,
                    'relation_type' => 'preferred_ingredient',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (isset($data['avoidedIngredientIds'])) {
            foreach ($data['avoidedIngredientIds'] as $id) {
                $relations[] = [
                    'user_id' => $this->user->id,
                    'related_id' => $id,
                    'relation_type' => 'avoided_ingredient',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($relations)) {
            DB::table('beauty_profile_relations')->insert($relations);
        }

        return $profile->load(['skinType', 'skinConcerns', 'preferredIngredients', 'avoidedIngredients']);
    }

    public function getQuestionnaireOptions()
    {
        return [
            'skinTypes' => SkinType::all(),
            'skinConcerns' => SkinConcern::all(),
            'activeIngredients' => ActiveIngredient::all(),
        ];
    }

    public function getProfile()
    {
        return BeautyProfile::with(['skinType', 'skinConcerns', 'preferredIngredients', 'avoidedIngredients'])
            ->where('user_id', $this->user->id)
            ->first();
    }
}
