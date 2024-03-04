<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserRolePermissionSeeder::class,
            MenuSeeder::class,
            CategorySeeder::class,
            CampaignSeeder::class,
            RekeningSeeder::class,
            SliderSeeder::class,
            FaqSeeder::class,
            DonationSeeder::class
        ]);
    }
}
