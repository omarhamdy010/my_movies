<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{

    public function run()
    {

                // Create default user for each role

                $admin = \App\Models\Admin::create([

                    'name' => 'super_admin',
                    'image' => 'default.png',
                    'email' => 'super@admin.com',
                    'password' => bcrypt(12345678),
                ]);

                $admin->attachRole('super_admin');

    }
}
