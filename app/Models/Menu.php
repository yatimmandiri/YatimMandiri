<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'menu_icon',
        'menu_link',
        'menu_parent',
        'menu_order'
    ];

    protected function childs()
    {
        return $this->hasMany(Menu::class, 'menu_parent', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_menus');
    }
}
