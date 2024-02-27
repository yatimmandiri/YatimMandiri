<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'menu_name' => 'Dashboard',
                'menu_link' => '/home',
                'menu_icon' => 'fas fa-tachometer-alt nav-icons',
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'System Core',
                'menu_link' => '#',
                'menu_icon' => 'fab fa-codepen nav-icons',
                'menu_parent' => 0,
            ],
            [
                'menu_name' => 'Permission',
                'menu_link' => '/core/permissions',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 2,
            ],
            [
                'menu_name' => 'Roles',
                'menu_link' => '/core/roles',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 2,
            ],
            [
                'menu_name' => 'Menu',
                'menu_link' => '/core/menus',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 2,
            ],
            [
                'menu_name' => 'Management Users',
                'menu_link' => '/core/users',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 2,
            ],
            [
                'menu_name' => 'Master Data',
                'menu_link' => '#',
                'menu_icon' => 'fas fa-database nav-icons',
                'menu_parent' => 0,
            ],
            // [
            //     'menu_name' => 'Majalah YM',
            //     'menu_link' => '#',
            //     'menu_icon' => 'fas fa-database nav-icons',
            //     'menu_parent' => 0,
            // ],
            // [
            //     'menu_name' => 'Company Profile',
            //     'menu_link' => '#',
            //     'menu_icon' => 'fas fa-database nav-icons',
            //     'menu_parent' => 0,
            // ],
            // [
            //     'menu_name' => 'Transaksi',
            //     'menu_link' => '#',
            //     'menu_icon' => 'fas fa-shopping-cart nav-icons',
            //     'menu_parent' => 0,
            // ],
            // [
            //     'menu_name' => 'Report',
            //     'menu_link' => '#',
            //     'menu_icon' => 'fas fa-print nav-icons',
            //     'menu_parent' => 0,
            // ],
            // [
            //     'menu_name' => 'Pengaturan',
            //     'menu_link' => '#',
            //     'menu_icon' => 'fas fa-cogs nav-icons',
            //     'menu_parent' => 0,
            // ],
        ])->each(fn ($menu) => Menu::create($menu)->roles()->sync(1));

        collect([
            ['name' => 'view-menu'],
            ['name' => 'create-menu'],
            ['name' => 'update-menu'],
            ['name' => 'delete-menu'],
        ])->each(fn ($permission) => Permission::create($permission)->syncRoles(['Administrators']));
    }
}
