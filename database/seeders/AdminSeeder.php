<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $super_admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'spadmin@gmail.com',
            'phone' => '987456321',            
            'password' => Hash::make('password'),
        ]);
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '9876615675',  
            'password' => Hash::make('password'),
        ]);

        $sp_admin_role = Role::create(['name' => 'Super-Admin', 'guard_name' => 'admin']);
        $admin_role = Role::create(['name' => 'admin', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Role access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Role edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Role create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Role delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Admin access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Admin edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Admin create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Admin delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Permission access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Permission edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Permission create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Permission delete', 'guard_name' => 'admin']);

        $super_admin->assignRole($sp_admin_role);
        $admin->assignRole($admin_role);

        $admin_role->givePermissionTo(Permission::all());
    }
}
