<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLearningPathwayAssignmentIdToCourseAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_assignment', function (Blueprint $table) {
            if (!Schema::hasColumn('course_assignment', 'learning_pathway_assignment_id')) {
                $table->unsignedBigInteger('learning_pathway_assignment_id')->nullable();
                $table->foreign('learning_pathway_assignment_id')->references('id')->on('learning_pathway_assignments')->onDelete('cascade');
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
