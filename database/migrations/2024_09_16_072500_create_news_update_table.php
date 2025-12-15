<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsUpdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_update', function (Blueprint $table) {

            $table->increments('id'); // int UNSIGNED NOT NULL AUTO_INCREMENT

            $table->string('title', 191);
            $table->text('content');
            $table->text('icon')->nullable();

            $table->integer('status')->default(1)
                  ->comment('0 - disabled, 1 - enabled');

            $table->timestamps(); // created_at, updated_at

            $table->string('lang', 191)->default('en');
            $table->string('slug', 191)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_update');
    }
}
