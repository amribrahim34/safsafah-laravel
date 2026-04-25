<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardTopProductResource extends JsonResource
{
    /**
     * The resource is an OrderItem aggregate row with a loaded `product` relation.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->product;

        return [
            'id'          => $product?->id,
            'name_ar'     => $product?->name_ar,
            'name_en'     => $product?->name_en,
            'image_url'   => $product?->image_url,   // uses the model accessor
            'total_sold'  => (int) $this->total_sold,
        ];
    }
}
