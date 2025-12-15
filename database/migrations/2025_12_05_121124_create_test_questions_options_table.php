<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestQuestionsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_question_options', function (Blueprint $table) {
            $table->id();

            $table->text('temp_id')->nullable();

            $table->unsignedBigInteger('question_id')->nullable();

            $table->longText('option_text')->nullable();

            $table->tinyInteger('is_right')->default(0);

            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at

            // Optional: Add foreign key
            // $table->foreign('question_id')->references('id')->on('test_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_question_options');
    }
}
