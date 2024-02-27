<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'categories_name' => $this->categories_name,
            'categories_title' => $this->categories_title,
            'categories_slug' => $this->categories_slug,
            'categories_excerpt' => $this->categories_excerpt,
            'categories_description' => $this->categories_description,
            'categories_status' => $this->categories_status,
            'categories_populer' => $this->categories_populer,
            'categories_icons' => $this->categories_icon ? env('APP_STORAGE_URL') . $this->categories_icon : null,
            'categories_featureimage' => $this->categories_featureimage ? env('APP_STORAGE_URL') . $this->categories_featureimage : null,
            'relationship' => [
                'faqs' => $this->faqs,
                // 'campaigns' => $this->campaigns,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
