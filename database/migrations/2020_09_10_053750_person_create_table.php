<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PersonCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("person", function(Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("last_name");
            $table->string("inside_identifier");
            $table->string("phone");
            $table->string("email")->unique();
            $table->boolean("is_employed");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("person");
    }
}
