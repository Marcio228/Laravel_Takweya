<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('dob')->nullable();
            $table->integer('grade_id')->unsigned();
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
//            $table->string('subject')->nullable();
            $table->integer('is_online')->default(0);
            $table->timestamps();
        });

        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->integer('subject_id')->unsigned();
            $table->integer('teacher_id')->unsigned();

            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['subject_id', 'teacher_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_teacher');
        Schema::dropIfExists('teachers');
    }
}
