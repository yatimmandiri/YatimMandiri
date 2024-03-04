<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'kode_user' => $this->kode_user,
            'name' => $this->name,
            'email' => $this->email,
            'handphone' => $this->handphone,
            'kantor_id' => $this->kantor_id,
            'referals' => $this->referals,
            'relationship' => [
                'roles' => $this->roles,
                'donations' => $this->donations
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
