<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('student_answers_student_id');
            $table->integer('student_answers_learning_path_id')->nullable();
            $table->integer('student_answers_learning_path_item_id');
            $table->json('student_answers_object');
            $table->json('student_answers_time_object')->nullable();
            $table->json('student_answers_attempts_object')->nullable();
            $table->json('student_answers_teacher_object')->nullable();
            $table->integer('student_answers_state')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_answers');
    }
}
