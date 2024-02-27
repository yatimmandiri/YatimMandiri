<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        collect([
            ['name' => 'Administrators'],
            ['name' => 'Operators'],
            ['name' => 'Users'],
            ['name' => 'Zisco']
        ])->each(fn ($role) => Role::create($role));

        collect([
            ['name' => 'view-permission'],
            ['name' => 'create-permission'],
            ['name' => 'update-permission'],
            ['name' => 'delete-permission'],
            ['name' => 'view-role'],
            ['name' => 'create-role'],
            ['name' => 'update-role'],
            ['name' => 'delete-role'],
            ['name' => 'view-user'],
            ['name' => 'create-user'],
            ['name' => 'update-user'],
            ['name' => 'delete-user'],
        ])->each(fn ($permission) => Permission::create($permission)->assignRole('Administrators'));

        User::create([
            'kode_user' => 53  . date('Yms') . random_int(10, 99),
            'name' => 'Yatim Mandiri',
            'email' => 'scrum@yatimmandiri.org',
            'handphone' => '6289676667010',
            'email_verified_at' => now(),
            'kantor_id' => 53,
            'password' => Hash::make('admin'), // password
        ])->assignRole('Administrators');

        User::create([
            'kode_user' => 53  . date('Yms') . random_int(10, 99),
            'name' => 'Digital Yatim Mandiri',
            'email' => 'digital@yatimmandiri.org',
            'handphone' => '081232867866',
            'email_verified_at' => now(),
            'kantor_id' => 53,
            'password' => Hash::make('operators123'), // password
        ])->assignRole('Operators');

        User::create([
            'kode_user' => 53  . date('Yms') . random_int(10, 99),
            'name' => 'News & Blog',
            'email' => 'roqibbruch2012@gmail.com',
            'handphone' => '0812328678',
            'email_verified_at' => now(),
            'kantor_id' => 53,
            'password' => Hash::make('zisco'), // password
        ])->assignRole('Zisco');
    }
}
