<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Super Admin user
        $superAdmin = User::create([
            'group_id' => 1,
            'field_id' => 1,
            'name' => 'Super Admin',
            'email' => 'su@gmail.com',
            'password' => bcrypt('Password123!'),
        ]);

        $superAdminPermissions = Permission::all();
        $superAdminRole = Role::find(1);
        $superAdminRole->syncPermissions($superAdminPermissions);
        $superAdmin->assignRole($superAdminRole);
    }
}
