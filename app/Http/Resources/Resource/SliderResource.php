<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slider_name' => $this->slider_name,
            'slider_link' => $this->slider_link,
            'slider_group' => $this->slider_group,
            'slider_featureimage' => $this->slider_featureimage,
        ];
    }
}
