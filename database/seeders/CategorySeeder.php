<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'menu_name' => 'Categories',
            'menu_link' => '/master/categories',
            'menu_icon' => 'fas fa-chevron-right nav-icons',
            'menu_parent' => 7,
        ])->roles()->sync([1, 2]);

        collect([
            ['name' => 'view-category'],
            ['name' => 'create-category'],
            ['name' => 'update-category'],
            ['name' => 'delete-category'],
        ])->each(fn ($permission) => Permission::create($permission)->syncRoles(['Administrators', 'Operators']));

        $categoriesRes = Http::get('https://dev.yatimmandiri.org/api/v1/categories')->json()['data'];
        foreach ($categoriesRes as $key) {
            $data = [
                "id" => $key['id'],
                "categories_name" => $key['categories_name'],
                "categories_title" => Str::title($key['categories_title']),
                "categories_slug" => $key['categories_slug'],
                "categories_excerpt" => $key['categories_excerpt'],
                "categories_description" => $key['categories_description'],
                "categories_status" => $key['categories_status'],
                "categories_populer" => $key['categories_populer'],
                // "categories_icon" => $key['categories_icons'],
                // "categories_featureimage" => $key['categories_featureimage'],
                'created_at' => $key['created_at'],
                'updated_at' => $key['updated_at']
            ];

            Category::create($data);
        }
    }
}
