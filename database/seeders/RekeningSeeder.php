<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Rekening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'menu_name' => 'Rekening',
            'menu_link' => '/master/rekenings',
            'menu_icon' => 'fas fa-chevron-right nav-icons',
            'menu_parent' => 7,
        ])->roles()->sync([1, 2]);

        collect([
            ['name' => 'view-rekening'],
            ['name' => 'create-rekening'],
            ['name' => 'update-rekening'],
            ['name' => 'delete-rekening'],
        ])->each(fn ($permission) => Permission::create($permission)->syncRoles(['Administrators', 'Operators']));

        $rekeningsRes = Http::get('https://dev.yatimmandiri.org/api/v1/rekenings')->json()['data'];
        foreach ($rekeningsRes as $key) {
            $data = [
                "id" => $key['id'],
                "rekening_name" => $key['rekening_name'],
                "rekening_number" => $key['rekening_number'],
                "rekening_bank" => $key['rekening_bank'],
                "rekening_provider" => $key['rekening_provider'],
                "rekening_token" => $key['rekening_token'],
                // "rekening_icon" => $key['rekening_icon'],
                "rekening_status" => $key['rekening_status'],
                // "rekening_populer" => $key['rekening_populer'],
                // "rekening_group" => $key['rekening_group'],
                'created_at' => $key['created_at'],
                'updated_at' => $key['updated_at']
            ];

            Rekening::create($data);
        }
    }
}
