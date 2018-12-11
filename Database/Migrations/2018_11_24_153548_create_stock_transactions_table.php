<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks');

            $table->unsignedInteger('repository_id');
            $table->foreign('repository_id')->references('id')->on('repositories');

            $table->integer('type'); //0: ongoing 1: outgoing

            $table->integer('quantity');

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
        Schema::dropIfExists('stock_transactions');
    }
}
