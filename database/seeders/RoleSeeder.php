<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Insert 'admin' role
        Role::create(['name' => 'admin']);

        // Insert 'non-admin' role
        Role::create(['name' => 'non-admin']);

    }
}
