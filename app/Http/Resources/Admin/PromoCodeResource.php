<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromoCodeResource extends JsonResource
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
            'code' => $this->code,
            'discount' => $this->discount,
            'is_percent' => $this->is_percent,
            'expiry_date' => $this->expiry_date,
            'usage_limit' => $this->usage_limit,
            'times_used' => $this->times_used,
            'active' => $this->active,
            'min_order_value' => $this->min_order_value,
            'max_discount_amount' => $this->max_discount_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
