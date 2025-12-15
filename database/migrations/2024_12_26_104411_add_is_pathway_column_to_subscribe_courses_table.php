<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPathwayColumnToSubscribeCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscribe_courses', function (Blueprint $table) {
            if (!Schema::hasColumn('subscribe_courses', 'is_pathway')) {
                $table->boolean('is_pathway')->default(false);
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
        Schema::table('subscribe_courses', function (Blueprint $table) {
            //
        });
    }
}
