<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users[0] = [
            'id'             => 1,
            'name'           => 'Super Admin',
            'email'          => 'superadmin@invoice.com',
            'username'       => 'superadmin',
            'password'       => bcrypt('12345678'),
            'remember_token' => null,
            'auth_pin'        => null,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_by'     => 1,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];
        $users[1] = [
            'id'             => 2,
            'name'           => 'Administrator',
            'email'          => 'admin@invoice.com',
            'username'       => 'admin',
            'password'       => bcrypt('12345678'),
            'remember_token' => null,
            'auth_pin'        => null,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_by'     => 1,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $users[2] = [
            'id'             => 3,
            'name'           => 'Accountant',
            'email'          => 'accountant@invoice.com',
            'username'       => 'accountant',
            'password'       => bcrypt('12345678'),
            'remember_token' => null,
            'auth_pin'        => null,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_by'     => 1,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $users[3] = [
            'id'             => 4,
            'name'           => 'Staff',
            'email'          => 'staff@invoice.com',
            'username'       => 'staff',
            'password'       => bcrypt('12345678'),
            'remember_token' => null,
            'auth_pin'        => null,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_by'     => 1,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        foreach($users as $key=>$user){
            $createdUser =  User::create($user);
        }
    }
}
