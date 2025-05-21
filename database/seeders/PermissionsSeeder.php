<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);

        // Create permissions
        Permission::create(['name' => 'access redis']);
        Permission::create(['name' => 'edit articles']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(['access redis', 'edit articles']);
        $editorRole->givePermissionTo('edit articles');

        // Assign role to a user (example)
        $user = \App\Models\User::find(1); // Adjust user ID
        $user->assignRole('admin');
    }
}
