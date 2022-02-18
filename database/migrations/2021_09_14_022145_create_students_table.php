<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('id_students');
            $table->string('name_students', 100);
            $table->date("birth_date");
            $table->enum('gender', ['M', 'F']);
            $table->text('address');
            $table->unsignedBigInteger("id_student_class");

            $table->foreign('id_student_class')->references('id_student_class')->on('student_class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
