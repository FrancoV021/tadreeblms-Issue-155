<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_feedbacks', function (Blueprint $table) {

        $table->bigIncrements('id');

        $table->bigInteger('course_id')->nullable();
        $table->bigInteger('feedback_question_id')->nullable();
        $table->bigInteger('created_by')->nullable();

        // optional:
        // $table->timestamps(); 
        // $table->foreign('course_id')->references('id')->on('courses');
        // $table->foreign('feedback_question_id')->references('id')->on('feedback_questions');
        // $table->foreign('created_by')->references('id')->on('users');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_feedbacks');
    }
}
