<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['name' => 'view-campaign'],
            ['name' => 'create-campaign'],
            ['name' => 'update-campaign'],
            ['name' => 'delete-campaign'],
        ])->each(fn ($permission) => Permission::create($permission)->syncRoles(['Administrators', 'Operators']));

        $campaignsRes = Http::get('https://dev.yatimmandiri.org/api/v1/campaigns')->json()['data'];
        foreach ($campaignsRes as $key) {
            $data = [
                "id" => $key['id'],
                "campaign_name" => $key['campaign_name'],
                "campaign_title" => $key['campaign_title'],
                "campaign_slug" => $key['campaign_slug'],
                "campaign_excerpt" => $key['campaign_excerpt'],
                "campaign_description" => $key['campaign_description'],
                "campaign_template" => $key['campaign_template'],
                "campaign_nominal" => $key['campaign_nominal'],
                "campaign_nominal_min" => $key['campaign_nominal_min'],
                // "campaign_featureimage" => $key['campaign_featureimage'],
                "campaign_status" => $key['campaign_status'],
                "campaign_populer" => $key['campaign_populer'],
                "paket_id" => $key['paket_id'],
                "categories_id" => $key['categories_id'],
                'created_at' => $key['created_at'],
                'updated_at' => $key['updated_at']
            ];

            Campaign::create($data);
        }
    }
}
