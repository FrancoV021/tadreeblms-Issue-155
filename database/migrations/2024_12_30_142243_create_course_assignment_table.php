<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('course_assignment', function (Blueprint $table) {

            $table->increments('id'); // int NOT NULL AUTO_INCREMENT

            $table->string('title', 255)->nullable();
            $table->string('course_id', 255)->nullable();
            $table->string('category_id', 255)->nullable();
            $table->string('department_id', 255)->nullable();
            $table->string('assign_by', 255)->nullable();
            $table->date('assign_date')->nullable();
            $table->string('assign_to', 255)->nullable();
            $table->date('due_date')->nullable();
            $table->string('message', 255)->nullable();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->tinyInteger('is_pathway')->default(0);
            $table->unsignedBigInteger('learning_pathway_assignment_id')->nullable();
            $table->integer('by_invitation')->default(0);
            $table->text('meeting_link')->nullable();
            $table->text('classroom_location')->nullable();
            $table->dateTime('meeting_end_datetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_assignment');
    }
}
