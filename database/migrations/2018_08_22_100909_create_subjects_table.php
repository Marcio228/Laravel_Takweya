<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
//            $table->integer('grade_id')->unsigned();
//            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('subject_grade', function (Blueprint $table) {
            $table->integer('subject_id')->unsigned();
            $table->integer('grade_id')->unsigned();

            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['subject_id', 'grade_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_grade');
        Schema::dropIfExists('subjects');
    }
}
