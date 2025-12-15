<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('user_id');

            $table->unsignedInteger('department')->nullable();
            $table->string('position')->nullable();

            $table->text('facebook_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('linkedin_link')->nullable();

            $table->string('payment_method', 191)->comment('paypal,bank');
            $table->text('payment_details');
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_profiles');
    }
}
