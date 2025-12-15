<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable.
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('access.table_names.users'), function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();

            $table->string('pincode')->nullable();

            $table->string('state')->nullable();
            $table->string('country')->nullable();
            //$table->string('id_number')->nullable();
            //$table->string('classfi_number')->nullable();

            $table->string('nationality')->nullable();
            $table->string('active_token')->nullable();
            //$table->string('classfi_number')->nullable();
            
            $table->string('avatar_type')->default('gravatar');
            $table->string('avatar_location')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('password_changed_at')->nullable();
            $table->tinyInteger('active')->default(1)->unsigned();
            $table->string('confirmation_code')->nullable();
            $table->boolean('confirmed')->default(config('access.users.confirm_email') ? false : true);
            $table->string('timezone')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('last_login_ip')->nullable();

            $table->string('employee_type')->nullable();

            $table->string('id_number', 255)->nullable();
            $table->string('classfi_number', 255)->nullable();
            //$table->string('nationality', 255)->nullable();
            $table->string('work_id', 255)->nullable();
            $table->string('cv_file', 255)->nullable();

            $table->string('stripe_id', 255)->nullable();
            $table->string('card_brand', 255)->nullable();

            $table->string('card_last_four', 255)->nullable();

            $table->text('emp_id')->nullable();

            $table->string('arabic_first_name', 191)->nullable();
            $table->string('arabic_last_name', 191)->nullable();

            $table->enum('fav_lang', ['english', 'arabic'])->default('english');

            $table->rememberToken();
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
        Schema::dropIfExists(config('access.table_names.users'));
    }
}
