<?php

namespace App\Http\Resources\App;

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
            'facebook'  => $this->facebook,
            'instagram' => $this->instagram,
            'tiktok'    => $this->tiktok,
            'whatsApp'  => $this->whatsApp,
            'email'     => $this->email,
            'mobile'    => $this->mobile,
        ];
    }
}
