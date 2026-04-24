<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            'mobile'       => $this->mobile,
            'points'       => $this->points,
            'orders_count' => $this->orders_count ?? 0,
            'created_at'   => $this->created_at?->toDateTimeString(),

            // Beauty profile — null when the user hasn't set one up yet
            'beauty_profile' => new BeautyProfileResource($this->whenLoaded('beautyProfile')),

            // All saved addresses
            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
        ];
    }
}
