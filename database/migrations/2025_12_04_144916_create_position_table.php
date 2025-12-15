<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('user_id');

            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('content')->nullable();
            $table->text('image')->nullable();
            $table->integer('sidebar')->default(0);

            $table->longText('meta_title')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();

            $table->tinyInteger('published')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('position');
    }
}
