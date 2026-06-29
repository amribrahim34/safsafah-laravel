<?php

namespace App\Http\Resources\App;

use App\Http\Resources\App\BlogCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'titleAr'          => $this->title_ar,
            'titleEn'          => $this->title_en,
            'contentAr'        => $this->content_ar,
            'contentEn'        => $this->content_en,
            'slug'             => $this->slug,
            'featuredImageUrl' => $this->featured_image_url,
            'readTime'         => $this->read_time,
            'publishedAt'      => $this->published_at,
            'categories'       => BlogCategoryResource::collection($this->whenLoaded('blogCategories')),
            'createdAt'        => $this->created_at,
            'updatedAt'        => $this->updated_at,
        ];
    }
}
