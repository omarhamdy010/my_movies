<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {

                // Create default user for each role
                $user = \App\Models\User::create([
                    'name' => 'super_admin',
                    'image' => 'default.png',
                    'email' => 'super@admin.com',
                    'password' => bcrypt(12345678),
                    'is_admin'=>1 ,
                ]);
                $user->attachRole('super_admin');

    }
}
