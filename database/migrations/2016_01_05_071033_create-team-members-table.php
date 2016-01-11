<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_members', function(Blueprint $table){
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
        });

        Schema::table('team_members', function(Blueprint $table) {
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users');
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
