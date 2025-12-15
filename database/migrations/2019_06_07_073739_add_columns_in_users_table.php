<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'dob')) {
                $table->string('dob')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('dob');
            }

            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->longText('address')->nullable()->after('gender');
            }

            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('address');
            }

            if (!Schema::hasColumn('users', 'pincode')) {
                $table->string('pincode')->nullable()->after('city');
            }

            if (!Schema::hasColumn('users', 'state')) {
                $table->string('state')->nullable()->after('pincode');
            }

            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable()->after('state');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dob', 'phone', 'gender', 'address', 'city', 'pincode', 'state', 'country']);
        });
    }
}
