<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCourseDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_course_detail', function (Blueprint $table) {
            $table->id(); // int auto-increment primary key

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('course_id');

            $table->enum('status', ['completed', 'inprogress'])->nullable();

            $table->enum('issue_certificate', ['yes', 'no'])
                  ->default('no');

            $table->text('certificate_url')->nullable();

            $table->dateTime('completed_at')->nullable();

            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_course_detail');
    }
}
