<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bar_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->integer('bar_category_id')->unsigned()->nullable();
            $table->foreign('bar_category_id')->references('id')->on('bar_categories');

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
        Schema::dropIfExists('categories');
    }
}
