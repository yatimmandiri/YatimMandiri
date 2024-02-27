<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'menu_name' => 'Slider',
            'menu_link' => '/master/sliders',
            'menu_icon' => 'fas fa-chevron-right nav-icons',
            'menu_parent' => 7,
        ])->roles()->sync([1, 2]);

        collect([
            ['name' => 'view-slider'],
            ['name' => 'create-slider'],
            ['name' => 'update-slider'],
            ['name' => 'delete-slider'],
        ])->each(fn ($permission) => Permission::create($permission)->syncRoles(['Administrators', 'Operators']));

        $slidersRes = Http::get('https://dev.yatimmandiri.org/api/v1/sliders')->json()['data'];
        foreach ($slidersRes as $key) {
            $data = [
                'slider_name' => $key['slider_name'],
                'slider_link' => $key['slider_link'],
                'slider_group' => $key['slider_group'],
                // 'slider_featureimage' => $key['slider_featureimage'],
                'created_at' => $key['created_at'],
                'updated_at' => $key['updated_at']
            ];

            Slider::create($data);
        }
    }
}
