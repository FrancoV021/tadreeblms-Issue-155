<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCourseFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_course_feedback', function (Blueprint $table) {
            $table->id(); // int AUTO_INCREMENT

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');

            $table->unsignedBigInteger('feedback_id')->nullable();

            $table->timestamps(); // created_at + updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_course_feedback');
    }
}
