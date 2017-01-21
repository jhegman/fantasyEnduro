<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('name');
            $table->string('password')->nullable();
            $table->timestamps();
        });

        Schema::create('league_user', function (Blueprint $table) //connect users, leagues
        {
            $table->integer('league_id')->unsigned()->index();
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('leagues');
        Schema::dropIfExists('league_user');
    }
}
