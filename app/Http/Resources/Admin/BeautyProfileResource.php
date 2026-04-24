<?php

namespace App\Http\Resources\Admin;

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
            'id'                    => $this->id,
            'skin_type'             => new SkinTypesResource($this->whenLoaded('skinType')),
            'allergies'             => $this->allergies,
            'skin_concerns'         => SkinConcernResource::collection($this->whenLoaded('skinConcerns')),
            'preferred_ingredients' => ActiveIngrediantResource::collection($this->whenLoaded('preferredIngredients')),
            'avoided_ingredients'   => ActiveIngrediantResource::collection($this->whenLoaded('avoidedIngredients')),
        ];
    }
}
