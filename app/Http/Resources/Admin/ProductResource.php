<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'description_ar' => $this->description_ar,
            'description_en' => $this->description_en,
            'price' => $this->price,
            'sku' => $this->sku,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')), // Assuming CategoryResource exists
            'brand_id' => $this->brand_id,
            'brand' => $this->whenLoaded('brand'), // Or BrandResource if exists
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'active_ingredients' => ActiveIngrediantResource::collection($this->whenLoaded('activeIngredients')),
            'skin_types' => $this->whenLoaded('skinTypes'), // Or SkinTypeResource
            'skin_concerns' => $this->whenLoaded('skinConcerns'), // Or SkinConcernResource
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
