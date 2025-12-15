<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_comments', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto-increment primary key

            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();

            $table->string('comment', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_comments');
    }
}
