<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_details', function (Blueprint $table) {
            $table->id('id_return_details');
            $table->integer('qty');
            $table->unsignedBigInteger('id_book_return');
            $table->unsignedBigInteger('id_book');

            $table->foreign('id_book_return')->references('id_book_return')->on('book_return');
            $table->foreign('id_book')->references('id_book')->on('book');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_details');
    }
}
