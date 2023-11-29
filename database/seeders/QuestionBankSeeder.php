<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuestionBank;

class QuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quizId = 1; // Replace with the actual Quiz ID

        QuestionBank::create([
            'quiz_id' => $quizId,
            'question' => 'What is the primary benefit of regular exercise?',
            'option1' => 'Increased strength and endurance',
            'option2' => 'Better cardiovascular health',
            'option3' => 'Improved flexibility',
            'option4' => 'All of the above',
            'answer' => '4', // Assuming 'All of the above' is the correct answer
        ]);

        

        // Create more gym-related questions
        QuestionBank::create([
            'quiz_id' => $quizId,
            'question' => 'Which exercise is best for building muscle mass?',
            'option1' => 'Running',
            'option2' => 'Cycling',
            'option3' => 'Weightlifting',
            'option4' => 'Yoga',
            'answer' => '3', // Weightlifting
        ]);

        QuestionBank::create([
            'quiz_id' => $quizId,
            'question' => 'What is the recommended frequency for cardiovascular exercise?',
            'option1' => 'Once a week',
            'option2' => 'Three times a week',
            'option3' => 'Every day',
            'option4' => 'Once a month',
            'answer' => '2', // Three times a week
        ]);


    }
}
