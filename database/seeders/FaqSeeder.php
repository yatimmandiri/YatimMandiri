<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'menu_name' => 'Faq',
            'menu_link' => '/master/faqs',
            'menu_icon' => 'fas fa-chevron-right nav-icons',
            'menu_parent' => 7,
            'menu_order' => 11,
        ])->roles()->sync([1, 2]);

        collect([
            ['name' => 'view-faq'],
            ['name' => 'create-faq'],
            ['name' => 'update-faq'],
            ['name' => 'delete-faq'],
        ])->each(fn ($permission) => Permission::create($permission)->syncRoles(['Administrators', 'Operators']));

        $faqsRes = Http::get('https://dev.yatimmandiri.org/api/v1/faqs')->json()['data'];
        foreach ($faqsRes as $key) {
            $data = [
                "id" => $key['id'],
                "faq_name" => $key['faq_name'],
                "faq_content" => $key['faq_content'],
                "categories_id" => $key['categories_id'],
                'created_at' => $key['created_at'],
                'updated_at' => $key['updated_at']
            ];

            Faq::create($data);
        }
    }
}
