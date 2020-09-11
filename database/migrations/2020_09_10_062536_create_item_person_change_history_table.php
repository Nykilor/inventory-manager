<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPersonChangeHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_person_change_history', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId("item_id")->constrained('item');
            $table->foreignId("new_person_id")->constrained("person");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_person_change_history');
    }
}
