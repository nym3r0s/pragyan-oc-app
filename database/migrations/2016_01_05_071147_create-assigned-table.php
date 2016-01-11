<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned', function(Blueprint $table){
            $table->integer('task_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });

        Schema::table('assigned', function(Blueprint $table) {
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
