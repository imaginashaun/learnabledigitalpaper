<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeBaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knowledge_base_items', function (Blueprint $table) {
            $table->id();
            $table->string('knowledge_base_item_title')->nullable();
            $table->integer('knowledge_base_item_type')->nullable();
            $table->json('knowledge_base_item_object')->nullable();
            $table->string('knowledge_base_item_image')->nullable();
            $table->integer('knowledge_base_item_weight')->default(0);
            $table->integer('knowledge_base_item_state')->default(1);
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
        Schema::dropIfExists('knowledge_base_items');
    }
}
