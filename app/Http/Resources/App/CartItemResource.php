<?php

namespace App\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'productId' => $this->product_id,
            'productNameEn' => $this->product->name_en,
            'productNameAr' => $this->product->name_ar,
            'productPrice' => $this->product->price,
            'productImage' => $this->product->image_url,
            'productSlugAr' => $this->product->slug_ar,
            'productSlugEn' => $this->product->slug_en,
            'quantity' => $this->quantity,
            'subtotal' => $this->quantity * $this->product->price,
        ];
    }
}
