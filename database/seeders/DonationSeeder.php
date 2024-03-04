<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'menu_name' => 'Donations',
            'menu_link' => '/transaction/donations',
            'menu_icon' => 'fas fa-chevron-right nav-icons',
            'menu_parent' => 8,
            'menu_order' => 14,
        ])->roles()->sync([1, 2]);

        collect([
            ['name' => 'view-donations'],
            ['name' => 'create-donations'],
            ['name' => 'update-donations'],
            ['name' => 'delete-donations'],
        ])->each(fn ($permission) => Permission::create($permission)->syncRoles(['Administrators', 'Operators']));
    }
}
