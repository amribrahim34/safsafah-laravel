<?php

namespace App\Http\Resources\Website;

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
            'nameAr' => $this->name_ar,
            'nameEn' => $this->name_en,
            'descriptionAr' => $this->description_ar,
            'descriptionEn' => $this->description_en,
            'categoryId' => $this->category_id,
            'category'=> $this->category,
            'brand'=> $this->brand,
            'brandId' => $this->brand_id,
            'price' => $this->price,
            'image' => $this->image_url,
            'sku' => $this->sku,
            'rating' => $this->rating,
            'ratingCount' => $this->rating_count,
        ];
    }
}
