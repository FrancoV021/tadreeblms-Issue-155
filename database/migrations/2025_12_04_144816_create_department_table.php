<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department', function (Blueprint $table) {
            $table->id(); // UNSIGNED INT AUTO_INCREMENT PRIMARY KEY

            $table->unsignedBigInteger('user_id');

            $table->string('title', 191)->nullable();
            $table->string('slug', 191)->nullable();

            $table->longText('content')->nullable();
            $table->text('image')->nullable();

            $table->integer('sidebar')->default(0);

            $table->longText('meta_title')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();

            $table->tinyInteger('published')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Optional: If linked to users table
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department');
    }
}
