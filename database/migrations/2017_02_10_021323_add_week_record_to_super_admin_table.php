<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\SuperAdminOption;

class AddWeekRecordToSuperAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $weekExists = SuperAdminOption::where('option_name', 'week')->first();

        if (!$weekExists) {
            $weekRecord = new SuperAdminOption;
            $weekRecord->option_name = 'week';
            $weekRecord->option_value = '1';
            $weekRecord->save();
        }
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
