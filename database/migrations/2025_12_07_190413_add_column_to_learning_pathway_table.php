<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToLearningPathwayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_pathways', function (Blueprint $table) {
            if (!Schema::hasColumn('learning_pathways', 'in_sequence')) {
                $table->integer('in_sequence')->default(0);
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
        Schema::table('learning_pathways', function (Blueprint $table) {
            //
        });
    }
}
