<?php

namespace App\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'nameAr' => $this->name_ar,
            'nameEn' => $this->name_en,
            'slug'   => $this->slug,
        ];
    }
}
