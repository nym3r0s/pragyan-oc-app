<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function(Blueprint $table){
            $table->integer('task_id')->unique()->primary();
            $table->string('task_name',20);
            $table->string('task_completed',20);
            $table->integer('team_id');
            $table->timestamps();
        });

        Schema::table('tasks', function(Blueprint $table) {
            $table->foreign('team_id')
                  ->references('team_id')
                  ->on('teams');
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
