<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWeightToLessonTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lesson_types', function (Blueprint $table) {
            //

            $table->integer('lesson_type_weight')->default(0);

        });

        Schema::table('material_items', function (Blueprint $table) {
            $table->integer('material_item_state')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson_types', function (Blueprint $table) {
            //
        });
    }
}
