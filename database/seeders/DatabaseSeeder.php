<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {

        $this->call(LaratrustSeeder::class);

        $this->call(AdminSeeder::class);

//        \App\Models\Category::factory(10)->create();
//        \App\Models\Product::factory(10)->create();
//         \App\Models\User::factory(10)->create();

    }
}
