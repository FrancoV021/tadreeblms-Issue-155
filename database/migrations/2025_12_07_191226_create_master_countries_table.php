<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_countries', function (Blueprint $table) {
            $table->id();
            
            $table->string('name', 255);
            $table->string('name_ar', 200)->nullable();
            $table->string('code', 255);
            $table->string('icon', 255)->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_countries');
    }
}
