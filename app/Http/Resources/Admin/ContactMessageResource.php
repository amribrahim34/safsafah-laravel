<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
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
            'name' => $this->name,
            'mobile' => $this->mobile,
            'message' => $this->message,
            'file_url' => $this->file ? asset('storage/' . $this->file) : null, // Assuming standard storage link
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
