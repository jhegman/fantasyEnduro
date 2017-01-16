<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToRacerRace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('racer_race', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('racer_race', function (Blueprint $table) {
            $table->dropColumn([
                'overall_place',
                'stage_1_time',
                'stage_1_place',
                'stage_2_time',
                'stage_2_place',
                'stage_3_time',
                'stage_3_place',
                'stage_4_time',
                'stage_4_place',
                'stage_5_time',
                'stage_5_place',
                'stage_6_time',
                'stage_6_place',
                'stage_7_time',
                'stage_7_place',
            ]);
        });
    }
}
