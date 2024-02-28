<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RekeningResource extends JsonResource
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
            'rekening_name' => $this->rekening_name,
            'rekening_number' => $this->rekening_number,
            'rekening_bank' => $this->rekening_bank,
            'rekening_provider' => $this->rekening_provider,
            'rekening_token' => $this->rekening_token,
            'rekening_icon' => $this->rekening_icon,
            'rekening_status' => $this->rekening_status,
            'rekening_group' => $this->rekening_group,
            'relationship' => [],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
