<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'quantity'   => $this->quantity,
            'unit_price' => $this->unit_price,
            'total'      => $this->total,
            'product'    => $this->whenLoaded('product', fn () => [
                'id'        => $this->product->id,
                'name_ar'   => $this->product->name_ar,
                'name_en'   => $this->product->name_en,
                'price'     => $this->product->price,
                'sku'       => $this->product->sku,
                'image_url' => $this->product->image_url,
            ]),
        ];
    }
}
