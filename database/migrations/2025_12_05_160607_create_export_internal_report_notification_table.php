<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportInternalReportNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_internal_report_notification', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('download_link')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->dateTime('created_at')->nullable();
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
        Schema::dropIfExists('export_internal_report_notification');
    }
}
