<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $cekMenuRole = DB::table('role_has_menus')
            ->where('menu_id', $this->id)
            ->where('role_id', $request->user()
                ->roles[0]->id)
            ->get()
            ->count();

        return [
            'id' => $this->id,
            'menu_name' => $this->menu_name,
            'menu_icon' => $this->menu_icon,
            'menu_link' => $this->menu_link,
            'menu_parent' => $this->menu_parent,
            'menu_order' => $this->menu_order,
            'menu_show' => $cekMenuRole,
            'relationship' => [
                'roles' => $this->roles,
                'childs' => $this->childs,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
