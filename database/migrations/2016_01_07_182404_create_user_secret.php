<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSecret extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // This migration adds tje column secret to the users table
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->string('user_secret',100)->after('user_gcmid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
