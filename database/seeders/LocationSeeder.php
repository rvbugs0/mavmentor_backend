<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Insert 'admin' role
        Location::create(['id'=>1,'name' => 'MAC','imageURL'=>'gym.png']);
        Location::create(['id'=>2,'name' => 'Library','imageURL'=>'library.png']);
        Location::create(['id'=>3,'name' => 'Dining','imageURL'=>'food.png']);



    }
}
