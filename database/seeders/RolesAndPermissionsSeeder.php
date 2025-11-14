<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin; // Make sure to import the User model

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create some permissions
        $permissions = [
            'admin-create',
            'admin-edit',
            'admin-delete',
            'admin-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-list',
            'permission-add',
            'permission-edit',
            'permission-delete',
            'permission-list',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'admin', 
            ]);
        }

        // Create roles
        $adminRole = Role::create([
            'name' => 'super_admin',
            'guard_name' => 'admin',
        ]);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());

        // Create a dummy user
        $user = Admin::create([
            'name' => 'Yasir Jawed',
            'email' => 'yasir.jawed@a2zcreatorz.com',
            'password' => bcrypt('12345678'), // Make sure to hash the password
        ]);

        // Assign the 'admin' role to the dummy user
        $user->assignRole('super_admin');
    }
}