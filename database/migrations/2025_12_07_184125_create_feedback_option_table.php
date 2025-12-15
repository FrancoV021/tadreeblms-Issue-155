<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_option', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->nullable();

            $table->longText('option_text')->nullable();

            $table->tinyInteger('is_right')
                ->default(0)
                ->comment('0 = wrong, 1 = correct');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_option');
    }
}
