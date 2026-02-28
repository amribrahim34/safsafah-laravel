<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeautyProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'skinType' => new SkinTypeResource($this->skinType), // Can wrap in a resource if needed
            'skinConcerns' => SkinConcernResource::collection($this->skinConcerns), // Assuming relationship exists
            'allergies' => $this->allergies,
            'preferredIngredients' => ActiveIngredientResource::collection($this->preferredIngredients), // Assuming relationship exists
            'avoidedIngredients' => ActiveIngredientResource::collection($this->avoidedIngredients), // Assuming relationship exists
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
