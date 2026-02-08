<?php

namespace App\Http\Resources\Website;

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
            'skinTypes' => $this['skinTypes'] ?? [],
            'skinConcerns' => $this['skinConcerns'] ?? [],
            'activeIngredients' => $this['activeIngredients'] ?? [],
        ];
    }
}
