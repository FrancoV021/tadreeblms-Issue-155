<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAssignmentQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_questions', function (Blueprint $table) {

            $table->increments('id'); // int NOT NULL AUTO_INCREMENT
            $table->integer('assignment_id')->nullable();
            $table->integer('assessment_test_id')->nullable();
            $table->integer('assessment_account_id')->nullable();
            $table->integer('question_id')->nullable();

            $table->text('answer')->nullable();
            $table->text('answer_text')->nullable();

            $table->integer('is_correct')->default(0);
            $table->integer('marks')->default(0);
            $table->tinyInteger('attempt')->nullable();

            // old table did NOT have timestamps, so we skip them
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_questions');
    }
}
