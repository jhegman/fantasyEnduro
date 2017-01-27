<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceRacerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('race_racer')) {
            Schema::create('race_racer', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
                $table->integer('racer_id');
                $table->integer('race_id');
                $table->integer('overall_place');
                $table->string('stage_1_time')->nullable();
                $table->integer('stage_1_place')->nullable();
                $table->string('stage_2_time')->nullable();
                $table->integer('stage_2_place')->nullable();
                $table->string('stage_3_time')->nullable();
                $table->integer('stage_3_place')->nullable();
                $table->string('stage_4_time')->nullable();
                $table->integer('stage_4_place')->nullable();
                $table->string('stage_5_time')->nullable();
                $table->integer('stage_5_place')->nullable();
                $table->string('stage_6_time')->nullable();
                $table->integer('stage_6_place')->nullable();
                $table->string('stage_7_time')->nullable();
                $table->integer('stage_7_place')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('race_racer');
    }
}
