<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'slugAr' => $this->slug_ar,
            'slugEn' => $this->slug_en,
            'descriptionAr' => $this->description_ar,
            'descriptionEn' => $this->description_en,
            'categoryId' => $this->category_id,
            'category'=> $this->category,
            'brand'=> $this->brand,
            'brandId' => $this->brand_id,
            'price' => $this->price,
            'image' => $this->image_url,
            'sku' => $this->sku,
            'rating' => round($this->rating ?? 0, 1),
            'isInWishlist' => $this->is_in_wishlist,
            "isRecommended" => $this->is_recommended ?? false,
            'ratingCount' => $this->rating_count,
        ];
    }
}
