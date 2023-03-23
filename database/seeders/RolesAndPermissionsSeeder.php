<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'read own user']);
        Permission::create(['name' => 'update own user']);

        Permission::create(['name' => 'create enquiries']);
        Permission::create(['name' => 'read enquiries']);
        Permission::create(['name' => 'update enquiries']);
        Permission::create(['name' => 'delete enquiries']);

        Permission::create(['name' => 'create invitations']);
        Permission::create(['name' => 'read invitations']);
        Permission::create(['name' => 'update invitations']);
        Permission::create(['name' => 'delete invitations']);

        Permission::create(['name' => 'create phones']);
        Permission::create(['name' => 'read phones']);
        Permission::create(['name' => 'update phones']);
        Permission::create(['name' => 'delete phones']);

        Permission::create(['name' => 'create addresses']);
        Permission::create(['name' => 'read addresses']);
        Permission::create(['name' => 'update addresses']);
        Permission::create(['name' => 'delete addresses']);

        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'read roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'read permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        // create roles and assign existing permissions
        $superAdmin = Role::create(['name' => 'super admin']);
        $superAdmin->givePermissionTo(Permission::all());
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        /*
         * Admin
         */
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo('create users');
        $admin->givePermissionTo('read users');
        $admin->givePermissionTo('update users');
        $admin->givePermissionTo('delete users');

        $admin->givePermissionTo('create enquiries');
        $admin->givePermissionTo('read enquiries');
        $admin->givePermissionTo('update enquiries');
        $admin->givePermissionTo('delete enquiries');

        $admin->givePermissionTo('create invitations');
        $admin->givePermissionTo('read invitations');
        $admin->givePermissionTo('update invitations');
        $admin->givePermissionTo('delete invitations');

        $admin->givePermissionTo('create addresses');
        $admin->givePermissionTo('read addresses');
        $admin->givePermissionTo('update addresses');
        $admin->givePermissionTo('delete addresses');

        $admin->givePermissionTo('create phones');
        $admin->givePermissionTo('read phones');
        $admin->givePermissionTo('update phones');
        $admin->givePermissionTo('delete phones');

    }
}
