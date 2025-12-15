<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStuFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stu_feedback', function (Blueprint $table) {
            $table->id(); // int UNSIGNED AUTO_INCREMENT

            $table->unsignedBigInteger('user_id');

            $table->text('content');

            $table->integer('status')
                ->default(1) // 1 = enabled
                ->comment('0 - disabled, 1 - enabled');

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stu_feedback');
    }
}
