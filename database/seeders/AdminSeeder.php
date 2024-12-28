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
            'code' => 'G',
            'email' => 'contact@ehoists.in',
            'phone' => '9830084490',            
            'password' => Hash::make('Passw@rd')            
        ]);
        // $admin = Admin::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@elequip.com',
        //     'phone' => '9876615675',  
        //     'password' => Hash::make('password'),
        // ]);

        $sp_admin_role = Role::create(['name' => 'Super-Admin', 'guard_name' => 'admin']);
        $admin_role = Role::create(['name' => 'Admin', 'guard_name' => 'admin']);
        $sales_role = Role::create(['name' => 'Sales', 'guard_name' => 'admin']);
        $factory_role = Role::create(['name' => 'Factory', 'guard_name' => 'admin']);

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

        $permission = Permission::create(['name' => 'Lead Category access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead Category create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead Category edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead Category delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Lead Stage access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead Stage create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead Stage edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead Stage delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'LeadSource access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'LeadSource create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'LeadSource edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'LeadSource delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'MeasuringUnit access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'MeasuringUnit create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'MeasuringUnit edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'MeasuringUnit delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Brand access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Brand create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Brand edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Brand delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'SmsFormat access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'SmsFormat create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'SmsFormat edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'SmsFormat delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Company access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Company create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Company edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Company delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Customer access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Customer create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Customer edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Customer delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'ProductCategory access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'ProductCategory create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'ProductCategory edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'ProductCategory delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'ProductSubCategory access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'ProductSubCategory create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'ProductSubCategory edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'ProductSubCategory delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Product access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Product create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Product edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Product delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Lead access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead delete', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead Assign', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Lead Remarks', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Proforma', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Order access', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Order create', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Order edit', 'guard_name' => 'admin']);
        $permission = Permission::create(['name' => 'Order delete', 'guard_name' => 'admin']);

        $permission = Permission::create(['name' => 'Report access', 'guard_name' => 'admin']);

        $super_admin->assignRole($sp_admin_role);
        // $admin->assignRole($admin_role);

        $admin_role->givePermissionTo(Permission::all());
        $sales_role->givePermissionTo(['ProductCategory access', 'ProductCategory create','ProductCategory edit','ProductSubCategory access', 'ProductSubCategory create', 'ProductSubCategory edit', 'Product access', 'Product create', 'Product edit', 'Lead access', 'Lead create', 'Lead edit', 'Lead Remarks', 'Proforma', 'Company access', 'Company create','Company edit','Customer access', 'Customer create', 'Customer edit']);
        $factory_role->givePermissionTo(['Lead access', 'Lead create', 'Lead edit', 'Lead Remarks', 'Proforma']);
    }
}
