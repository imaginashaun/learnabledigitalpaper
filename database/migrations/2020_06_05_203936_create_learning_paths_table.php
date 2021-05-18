<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningPathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_paths', function (Blueprint $table) {
            $table->id();
            $table->string('learning_path_title')->nullable();
            $table->mediumText('learning_path_desc')->nullable();
            $table->integer('learning_path_subject')->nullable();
            $table->integer('learning_path_educator')->nullable();
            $table->string('learning_path_code')->nullable();
            $table->integer('learning_path_theme')->nullable();
            $table->integer('learning_path_state')->default(1);
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
        Schema::dropIfExists('learning_paths');
    }
}
