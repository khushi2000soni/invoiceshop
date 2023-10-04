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
            'name'           => 'Administrator',
            'email'          => 'admin@admin.com',
            'username'       => 'admin@admin.com',
            'password'       => bcrypt('Password'),
            'remember_token' => null,
            'authpin'        => null,
            'role_id'        => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $users[1] = [
            'id'             => 2,
            'name'           => 'Rohan',
            'email'          => 'rohan@gmail.com',
            'username'       => 'rohan@gmail.com',
            'password'       => bcrypt('Password'),
            'remember_token' => null,
            'authpin'        => null,
            'role_id'        => 2,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        $users[2] = [
            'id'             => 3,
            'name'           => 'Rahul Meena',
            'email'          => 'rahul@gmail.com',
            'username'       => 'rahul@gmail.com',
            'password'       => bcrypt('Password'),
            'remember_token' => null,
            'authpin'        => null,
            'role_id'        => 3,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        foreach($users as $key=>$user){
            $createdUser =  User::create($user);

        }
    }
}
