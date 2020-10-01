<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("serial");
            $table->string("model");
            $table->string("producer");
            $table->foreignId("person_id")->nullable()->constrained('person');
            $table->string("inside_identifier");
            $table->boolean('is_disposed');
            $table->foreignId('disposed_by_person_id')->nullable()->constrained('person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
