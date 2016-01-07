<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table){
            $table->integer('user_id')->unique()->primary();
            $table->string('user_roll',20);
            $table->string('user_name',20);
            $table->string('user_gcmid',300);
            $table->string('user_phone',20);
            $table->string('user_type',20);
            $table->timestamps();
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
