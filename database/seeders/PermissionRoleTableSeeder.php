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
        // role_create ,role_edit,role_show, role_delete role_access profile_access profile_edit user_change_password address_access address_create address_edit address_delete staff_access staff_create staff_edit staff_show staff_delete customer_access customer_create customer_edit customer_show customer_delete master_access category_access category_create category_edit category_show category_delete product_access product_create product_edit product_show product_delete  device_access device_create device_edit device_show device_delete invoice_access invoice_create invoice_edit invoice_show invoice_print invoice_share invoice_download invoice_delete invoice_restore order_product_access order_product_create order_product_copy order_product_edit order_product_show order_product_delete report_access get_sales_report_access setting_access  setting_edit product_merge product_print product_export category_print category_export address_print address_export report_invoice_access report_category_access phone_book_access phone_book_print phone_book_export invoice_recycle_access customer_print customer_export staff_print staff_export

        $roles = Role::all();
        $superadminpermissionid= Permission::all();
        $adminpermissionid= Permission::all();

        $accountantpermissionid= Permission::whereIn('name',['profile_access', 'profile_edit', 'user_change_password' ,'invoice_access','invoice_access','invoice_create','invoice_delete','invoice_edit','invoice_show','invoice_print', 'invoice_share' ,'invoice_download', 'order_product_access', 'order_product_create', 'order_product_copy' ,'order_product_edit', 'order_product_delete' ,'customer_access','customer_edit','customer_access','customer_create'])->pluck('id')->toArray();

        $staffpermissionid= Permission::whereIn('name',['profile_access', 'profile_edit', 'user_change_password' ,'invoice_access','invoice_access','invoice_create','invoice_delete','invoice_edit','invoice_show','invoice_print', 'invoice_share' ,'invoice_download', 'order_product_access', 'order_product_create', 'order_product_copy' ,'order_product_edit', 'order_product_delete' ,'customer_access','customer_edit','customer_access','customer_create'])->pluck('id')->toArray();

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
