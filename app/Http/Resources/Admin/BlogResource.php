<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\BlogCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'title_ar'           => $this->title_ar,
            'title_en'           => $this->title_en,
            'content_ar'         => $this->content_ar,
            'content_en'         => $this->content_en,
            'slug'               => $this->slug,
            'featured_image_url' => $this->featured_image_url,
            'read_time'          => $this->read_time,
            'published_at'       => $this->published_at,
            'categories'         => BlogCategoryResource::collection($this->whenLoaded('blogCategories')),
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
        ];
    }
}
