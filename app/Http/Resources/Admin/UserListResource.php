<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'mobile'          => $this->mobile,
            'points'          => $this->points,
            'orders_count'    => $this->orders_count ?? 0,
            'has_beauty_profile' => $this->relationLoaded('beautyProfile')
                                    ? ! is_null($this->beautyProfile)
                                    : (bool) ($this->beauty_profile_count ?? 0),
            'created_at'      => $this->created_at?->toDateTimeString(),
        ];
    }
}
