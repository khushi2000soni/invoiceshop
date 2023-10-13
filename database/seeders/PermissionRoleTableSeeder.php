<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = Role::all();
        $superadminpermissionid= Permission::all();
        $adminpermissionid= Permission::all();

        $accountantpermissionid= Permission::whereIn('name',['invoice_access','invoice_access','invoice_create','invoice_delete','invoice_edit','invoice_show','profile_access','profile_edit','customer_management_access','customer_show','customer_access','customer_create',])->pluck('id')->toArray();

        $staffpermissionid= Permission::whereIn('name',['invoice_access','invoice_access','invoice_create','invoice_delete','invoice_edit','invoice_show','profile_access','profile_edit','customer_show','customer_access','customer_create',])->pluck('id')->toArray();

        foreach ($roles as $role) {
            switch ($role->id) {
                case 1:
                    $role->givePermissionTo($superadminpermissionid);
                    break;
                case 2:
                    $role->givePermissionTo($adminpermissionid);
                    break;
                case 3:
                    $role->givePermissionTo($accountantpermissionid);
                    break;
                case 4:
                    $role->givePermissionTo($staffpermissionid);
                    break;
                default:
                    break;
            }
        }
    }
}
