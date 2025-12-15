<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCourseAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_assignment', function (Blueprint $table) {
            if (!Schema::hasColumn('course_assignment', 'reschedule')) {
                $table->integer('reschedule')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_assignment', function (Blueprint $table) {
            //
        });
    }
}
