<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrow', function (Blueprint $table) {
            $table->id('id_borrow');
            $table->date('date_borrow');
            $table->unsignedBigInteger('id_book');
            $table->unsignedBigInteger('id_students');

            $table->foreign('id_students')->references('id_students')->on('students');
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
        Schema::dropIfExists('borrow');
    }
}
