<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $updateDate = $createDate = date('Y-m-d H:i:s');
        $permissions = [

            // [
            //     'name'      => 'permission_create',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            // [
            //     'name'      => 'permission_edit',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            // [
            //     'name'      => 'permission_show',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            // [
            //     'name'      => 'permission_delete',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],
            // [
            //     'name'      => 'permission_access',
            //     'guard_name'=>'web',
            //     'route_name'=>'permissions',
            //     'created_at' => $createDate,
            //     'updated_at' => $updateDate,
            // ],

            [
                'name'      => 'role_create',
                'guard_name'=>'web',
                'route_name'=>'roles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'role_edit',
                'guard_name'=>'web',
                'route_name'=>'roles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'role_show',
                'guard_name'=>'web',
                'route_name'=>'roles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'role_delete',
                'guard_name'=>'web',
                'route_name'=>'roles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'role_access',
                'guard_name'=>'web',
                'route_name'=>'roles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'profile_access',
                'guard_name'=>'web',
                'route_name'=>'profiles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'profile_edit',
                'guard_name'=>'web',
                'route_name'=>'profiles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'user_change_password',
                'guard_name'=>'web',
                'route_name'=>'profiles',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'address_access',
                'guard_name'=>'web',
                'route_name'=>'address',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'address_create',
                'guard_name'=>'web',
                'route_name'=>'address',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'address_edit',
                'guard_name'=>'web',
                'route_name'=>'address',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'address_delete',
                'guard_name'=>'web',
                'route_name'=>'address',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'staff_access',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'staff_create',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'staff_edit',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'staff_show',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'staff_delete',
                'guard_name'=>'web',
                'route_name'=>'staff',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'customer_access',
                'guard_name'=>'web',
                'route_name'=>'customers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'customer_create',
                'guard_name'=>'web',
                'route_name'=>'customers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'customer_edit',
                'guard_name'=>'web',
                'route_name'=>'customers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'customer_show',
                'guard_name'=>'web',
                'route_name'=>'customers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'customer_delete',
                'guard_name'=>'web',
                'route_name'=>'customers',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'master_access',
                'guard_name'=>'web',
                'route_name'=>'master',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'category_access',
                'guard_name'=>'web',
                'route_name'=>'categories',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'category_create',
                'guard_name'=>'web',
                'route_name'=>'categories',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'category_edit',
                'guard_name'=>'web',
                'route_name'=>'categories',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'category_show',
                'guard_name'=>'web',
                'route_name'=>'categories',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'category_delete',
                'guard_name'=>'web',
                'route_name'=>'categories',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'product_access',
                'guard_name'=>'web',
                'route_name'=>'products',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'product_create',
                'guard_name'=>'web',
                'route_name'=>'products',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'product_edit',
                'guard_name'=>'web',
                'route_name'=>'products',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'product_show',
                'guard_name'=>'web',
                'route_name'=>'products',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'product_delete',
                'guard_name'=>'web',
                'route_name'=>'products',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'device_access',
                'guard_name'=>'web',
                'route_name'=>'devices',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'device_create',
                'guard_name'=>'web',
                'route_name'=>'devices',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'device_edit',
                'guard_name'=>'web',
                'route_name'=>'devices',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'device_show',
                'guard_name'=>'web',
                'route_name'=>'devices',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'device_delete',
                'guard_name'=>'web',
                'route_name'=>'devices',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'invoice_access',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'invoice_create',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'invoice_edit',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'invoice_show',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'invoice_print',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'invoice_share',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'invoice_download',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'invoice_delete',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'order_product_access',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'order_product_create',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'order_product_copy',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'order_product_edit',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'order_product_show',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'order_product_delete',
                'guard_name'=>'web',
                'route_name'=>'invoice',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'report_access',
                'guard_name'=>'web',
                'route_name'=>'reports',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'get_sales_report_access',
                'guard_name'=>'web',
                'route_name'=>'reports',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'      => 'setting_access',
                'guard_name'=>'web',
                'route_name'=>'settings',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'setting_create',
                'guard_name'=>'web',
                'route_name'=>'settings',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'setting_edit',
                'guard_name'=>'web',
                'route_name'=>'settings',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'setting_show',
                'guard_name'=>'web',
                'route_name'=>'settings',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'      => 'setting_delete',
                'guard_name'=>'web',
                'route_name'=>'settings',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
        ];

        Permission::insert($permissions);
    }
}
