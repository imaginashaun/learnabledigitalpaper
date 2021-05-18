<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentLearningPathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_learning_paths', function (Blueprint $table) {
            $table->id();
            $table->integer('student_learning_path_student_id');
            $table->integer('student_learning_path_lesson_id');
            $table->json('student_learning_path_object')->nullable();
            $table->integer('student_learning_path_state')->default(1);
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
        Schema::dropIfExists('student_learning_paths');
    }
}
