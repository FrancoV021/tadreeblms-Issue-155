<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToVideoProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_progresses', function (Blueprint $table) {
            if (!Schema::hasColumn('video_progresses', 'progress_per')) {
                $table->string('progress_per')->nullable()->after('progress');
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
        Schema::table('video_progress', function (Blueprint $table) {
            //
        });
    }
}
