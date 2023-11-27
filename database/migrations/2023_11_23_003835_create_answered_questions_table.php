<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{  public function up()
    {
        Schema::create('answered_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('question_banks');
            $table->tinyInteger('selected_answer')->unsigned()->between(1, 4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('answered_questions');
    }
};
