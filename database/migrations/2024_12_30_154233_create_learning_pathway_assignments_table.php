<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningPathwayAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_pathway_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('pathway_id');
            $table->integer('assigned_by')->unsigned();
            $table->text('assigned_to');
            $table->date('due_date');
            $table->timestamps();

            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pathway_id')->references('id')->on('learning_pathways')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_pathway_assignments');
    }
}
