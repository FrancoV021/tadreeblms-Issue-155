<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_feedback', function (Blueprint $table) {
           
            $table->id(); // INT auto-increment primary key

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('feedback_id')->nullable();

            $table->string('feedback', 255)->nullable();

            $table->integer('feedback_questions_type')
                  ->default(0)
                  ->comment('1: single_choice, 2: multiple_choice, 3: short_answer');

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_feedback');
    }
}
