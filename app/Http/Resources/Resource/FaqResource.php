<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            'faq_name' => $this->faq_name,
            'faq_content' => $this->faq_content,
            'faq_status' => $this->faq_status,
            'categories_id' => $this->categories_id,
            'relationship' => [
                'categories' => $this->categories,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
