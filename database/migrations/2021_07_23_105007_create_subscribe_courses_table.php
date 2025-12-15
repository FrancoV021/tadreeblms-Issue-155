<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribeCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_courses', function (Blueprint $table) {

            $table->bigIncrements('id'); // bigint unsigned primary key

            $table->unsignedInteger('stripe_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->unsignedInteger('course_id');

            $table->integer('status')->default(0);

            $table->date('assign_date')->nullable();
            $table->date('due_date')->nullable();

            $table->string('course_trainer_name', 200)->nullable();

            $table->integer('assesment_taken')->default(0);

            $table->string('assignment_progress', 100)->nullable();
            $table->string('assignment_status', 100)->nullable();
            $table->string('assignment_score', 100)->nullable();

            $table->integer('grant_certificate')->default(0);

            $table->timestamps();

            $table->integer('is_completed')->default(0)->comment('1 completed, 0 default');
            $table->softDeletes(); // deleted_at

            $table->tinyInteger('is_pathway')->default(0);
            $table->dateTime('completed_at')->nullable();

            $table->integer('by_invitation')->default(0);

            $table->integer('is_attended')->default(0);

            $table->integer('has_assesment')->default(0);

            $table->integer('feedback_given')->default(0);
            $table->integer('has_feedback')->default(0);

            $table->integer('course_progress_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_courses');
    }
}
