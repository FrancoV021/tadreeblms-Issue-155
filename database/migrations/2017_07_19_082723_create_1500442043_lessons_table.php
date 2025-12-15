<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1500442043LessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('lessons')) {
            Schema::create('lessons', function (Blueprint $table) {
                $table->increments('id');

                $table->text('temp_id')->nullable();
                $table->unsignedInteger('course_id')->nullable();

                $table->string('title', 191)->nullable();
                $table->string('arabic_title', 255)->nullable();
                $table->string('slug', 191)->nullable();

                $table->string('lesson_image', 191)->nullable();

                $table->text('short_text')->nullable();
                $table->text('full_text')->nullable();

                $table->unsignedInteger('position')->nullable();

                $table->tinyInteger('free_lesson')->default(1);
                $table->tinyInteger('published')->default(0);
                $table->tinyInteger('live_lesson')->default(0);

                $table->float('duration')->nullable();

                $table->dateTime('lesson_start_date')->nullable();

                $table->timestamps();
                $table->softDeletes();

                // Optional foreign key (only if course table exists)
                // $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
