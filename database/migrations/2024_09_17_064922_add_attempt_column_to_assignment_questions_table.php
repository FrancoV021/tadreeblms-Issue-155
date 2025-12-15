<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttemptColumnToAssignmentQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignment_questions', function (Blueprint $table) {
            if (!Schema::hasColumn('assignment_questions', 'attempt')) {
                $table->tinyInteger('attempt')->nullable();
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
        Schema::table('assignment_questions', function (Blueprint $table) {
            //
        });
    }
}
