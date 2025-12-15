<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangColumnToConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function (Blueprint $table) {
            if (!Schema::hasColumn('configs', 'lang')) {
                $table->string('lang')->default('en');
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
        Schema::table('configs', function (Blueprint $table) {
            //
        });
    }
}
