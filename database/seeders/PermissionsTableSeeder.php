<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission Dashboard
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);

        // Permission Users
        Permission::create(['name' => 'users.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.delete', 'guard_name' => 'web']);

        // Permission Field
        Permission::create(['name' => 'fields.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'fields.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'fields.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'fields.delete', 'guard_name' => 'web']);

        // Permission Activities
        Permission::create(['name' => 'activities.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'activities.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'activities.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'activities.show', 'guard_name' => 'web']);
        Permission::create(['name' => 'activities.delete', 'guard_name' => 'web']);

        // Permission Activities
        Permission::create(['name' => 'groups.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'groups.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'groups.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'groups.delete', 'guard_name' => 'web']);

        // Permission Roles
        Permission::create(['name' => 'roles.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.delete', 'guard_name' => 'web']);

        // Permission Permissions
        Permission::create(['name' => 'permissions.index', 'guard_name' => 'web']);
    }
}
