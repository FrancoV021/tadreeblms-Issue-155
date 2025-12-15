<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {

            $table->increments('id'); // int primary key

            $table->text('temp_id')->nullable();

            $table->integer('test_id')->nullable();

            $table->text('user_id')->nullable(); // Keeping as TEXT since original DB uses TEXT

            $table->string('course_id', 255)->nullable();
            $table->string('category_id', 255)->nullable();

            $table->integer('user_type')
                ->nullable()
                ->comment('1: pre-employee, 2: employee');

            $table->string('title', 255)->nullable();

            $table->integer('duration')
                ->nullable()
                ->comment('(in minutes)');

            $table->timestamp('start_time')->nullable()->comment('datetime of starting assignment');
            $table->timestamp('end_time')->nullable()->comment('Last time of starting the assignment');

            $table->dateTime('due_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->integer('buffer_time')->nullable()->comment('(in minutes)');

            $table->string('message', 255)->nullable();

            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamp('deleted_at')->nullable();

            $table->string('verify_code', 15)->nullable();
            $table->string('url_code', 255)->nullable();

            $table->integer('total_question')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
