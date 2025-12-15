<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAssesmentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_assignment_users', function (Blueprint $table) {

        $table->increments('id');

        $table->integer('course_assignment_id')->nullable();
        $table->integer('course_id')->nullable();
        $table->integer('user_id')->nullable();

        $table->string('log_comment', 50)->nullable();

        $table->dateTime('created_at')->nullable();
        $table->dateTime('updated_at')->nullable();
        $table->dateTime('deleted_at')->nullable();

        $table->integer('by_pathway')->default(0);
        $table->integer('by_invitation')->default(0);
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_assignment_users');
    }
}
