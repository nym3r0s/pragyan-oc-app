<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg', function(Blueprint $table){
            $table->integer('msg_id')->unique()->primary();
            $table->integer('task_id');
            $table->integer('user_id');
            $table->string('msg_data',1000);
            $table->timestamps();
        });

        Schema::table('msg', function(Blueprint $table) {
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users');
            $table->foreign('task_id')
                  ->references('task_id')
                  ->on('tasks');
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
