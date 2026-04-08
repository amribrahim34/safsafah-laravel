<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'facebook'   => $this->facebook,
            'instagram'  => $this->instagram,
            'tiktok'     => $this->tiktok,
            'whatsapp'   => $this->whatsapp,
            'email'      => $this->email,
            'mobile'     => $this->mobile,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
