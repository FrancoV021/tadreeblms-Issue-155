<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_questions', function (Blueprint $table) {
            
            $table->id(); // int auto-increment primary key

            $table->text('temp_id')->nullable();

            $table->integer('question_type')
                  ->nullable()
                  ->comment('1: single_choice, 2: multiple_choice, 3: short_answer');

            $table->unsignedInteger('test_id')->nullable();

            $table->longText('question_text')->nullable();
            $table->longText('solution')->nullable();

            $table->integer('marks')->default(0);

            $table->longText('comment')->nullable();

            $table->longText('option_json')->nullable();

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->integer('is_deleted')->default(0);

            $table->dateTime('deleted_at')->nullable();
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_questions');
    }
}
