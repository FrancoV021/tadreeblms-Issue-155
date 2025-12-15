<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_questions', function (Blueprint $table) {

        $table->bigIncrements('id');

        $table->text('temp_id')->nullable();

        $table->integer('course_id');

        $table->string('question')->nullable();
        $table->string('solution')->nullable();

        $table->integer('question_type')
              ->nullable()
              ->comment('1: single_choice, 2: multiple_choice, 3: short_answer');

        $table->longText('option_json')->nullable();

        $table->bigInteger('created_by')->nullable();

        $table->dateTime('deleted_at')->nullable();

        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_questions');
    }
}
