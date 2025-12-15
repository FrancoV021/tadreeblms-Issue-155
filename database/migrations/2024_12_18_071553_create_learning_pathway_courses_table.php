<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningPathwayCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_pathway_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pathway_id');
            $table->integer('course_id')->unsigned();
            $table->integer('position')->comment('for maintaining order of course');
            $table->timestamps();

            $table->foreign('pathway_id')->references('id')->on('learning_pathways')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_pathway_courses');
    }
}
