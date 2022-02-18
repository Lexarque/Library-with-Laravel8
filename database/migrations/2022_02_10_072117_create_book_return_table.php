<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_return', function (Blueprint $table) {
            $table->id('id_book_return');
            $table->date('date_return');
            $table->integer('late_fee');
            $table->unsignedBigInteger('id_borrow');

            $table->foreign('id_borrow')->references('id_borrow')->on('borrow');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return');
    }
}
