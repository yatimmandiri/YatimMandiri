<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'role_has_menus');
    }
}
