<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_access', function (Blueprint $table) {
            $table->id();
            $table->boolean("write");
            $table->boolean("read");
            $table->boolean("update");
            $table->foreignId("users_id")->constrained('users');
            $table->foreignId("category_id")->constrained('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_access');
    }
}
