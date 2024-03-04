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
                'menu_order' => 1
            ],
            [
                'menu_name' => 'System Core',
                'menu_link' => '#',
                'menu_icon' => 'fab fa-codepen nav-icons',
                'menu_parent' => 0,
                'menu_order' => 2
            ],
            [
                'menu_name' => 'Permission',
                'menu_link' => '/core/permissions',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 2,
                'menu_order' => 3
            ],
            [
                'menu_name' => 'Roles',
                'menu_link' => '/core/roles',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 2,
                'menu_order' => 4
            ],
            [
                'menu_name' => 'Menu',
                'menu_link' => '/core/menus',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 2,
                'menu_order' => 5
            ],
            [
                'menu_name' => 'Management Users',
                'menu_link' => '/core/users',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 2,
                'menu_order' => 6
            ],

            // [
            //     'menu_name' => 'Report',
            //     'menu_link' => '#',
            //     'menu_icon' => 'fas fa-print nav-icons',
            //     'menu_parent' => 0,
            // ],
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
            [
                'menu_name' => 'Master Data',
                'menu_link' => '#',
                'menu_icon' => 'fas fa-database nav-icons',
                'menu_parent' => 0,
                'menu_order' => 7
            ],
            [
                'menu_name' => 'Categories',
                'menu_link' => '/master/categories',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 7,
                'menu_order' => 8,
            ],
            [
                'menu_name' => 'Campaigns',
                'menu_link' => '/master/campaigns',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 7,
                'menu_order' => 9,
            ],
            [
                'menu_name' => 'Rekening',
                'menu_link' => '/master/rekenings',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 7,
                'menu_order' => 10,
            ],
            [
                'menu_name' => 'Faq',
                'menu_link' => '/master/faqs',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 7,
                'menu_order' => 11,
            ],
            [
                'menu_name' => 'Slider',
                'menu_link' => '/master/sliders',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 7,
                'menu_order' => 12,
            ],
            [
                'menu_name' => 'Transaksi',
                'menu_link' => '#',
                'menu_icon' => 'fas fa-shopping-cart nav-icons',
                'menu_parent' => 0,
                'menu_order' => 13
            ],
            [
                'menu_name' => 'Donations',
                'menu_link' => '/transaction/donations',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 13,
                'menu_order' => 14,
            ],
            [
                'menu_name' => 'Magazine',
                'menu_link' => '/transaction/donations',
                'menu_icon' => 'fas fa-newspaper nav-icons',
                'menu_parent' => 0,
                'menu_order' => 15,
            ],
            [
                'menu_name' => 'Categories',
                'menu_link' => '/magazines/categories',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 15,
                'menu_order' => 16,
            ],
            [
                'menu_name' => 'Majalah',
                'menu_link' => '/magazines/majalah',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 16,
                'menu_order' => 17,
            ],
            [
                'menu_name' => 'Report',
                'menu_link' => '#',
                'menu_icon' => 'fas fa-print nav-icons',
                'menu_parent' => 0,
                'menu_order' => 18
            ],
            [
                'menu_name' => 'Donations',
                'menu_link' => '/reports/donations',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 18,
                'menu_order' => 19,
            ],
            [
                'menu_name' => 'Data Donatur',
                'menu_link' => '/reports/donaturs',
                'menu_icon' => 'fas fa-chevron-right nav-icons',
                'menu_parent' => 18,
                'menu_order' => 20,
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
        ])->each(fn ($menu) => Menu::create($menu)->roles()->sync([1, 2]));

        collect([
            ['name' => 'view-menu'],
            ['name' => 'create-menu'],
            ['name' => 'update-menu'],
            ['name' => 'delete-menu'],
        ])->each(fn ($permission) => Permission::create($permission)->syncRoles(['Administrators']));
    }
}
