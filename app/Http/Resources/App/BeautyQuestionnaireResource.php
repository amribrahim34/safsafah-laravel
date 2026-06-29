<?php

namespace App\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeautyQuestionnaireResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'skinTypes' => SkinTypeResource::collection($this['skinTypes'] ?? []),
            'skinConcerns' => SkinConcernResource::collection($this['skinConcerns'] ?? []),
            'activeIngredients' => SkinActiveIngredientResource::collection($this['activeIngredients'] ?? []),
        ];
    }
}
