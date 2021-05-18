<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningPathItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_path_items', function (Blueprint $table) {
            $table->id();
            $table->string('learning_path_item_title')->nullable();
            $table->json('learning_path_item_object')->nullable();
            $table->integer('lesson_type_id')->nullable();
            $table->integer('learning_path_id')->nullable();
            $table->integer('learning_path_item_mark')->nullable();
            $table->integer('learning_path_item_state')->default(1);
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
        Schema::dropIfExists('learning_path_items');
    }
}
