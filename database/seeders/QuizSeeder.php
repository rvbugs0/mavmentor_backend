<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Quiz::create(['title' => 'Quiz-1','location'=>1,'expires_at'=>'2023-12-31 00:00:00']);
        Quiz::create(['title' => 'Quiz-2','location'=>1,'expires_at'=>'2023-12-31 00:00:00']);

    }
}
