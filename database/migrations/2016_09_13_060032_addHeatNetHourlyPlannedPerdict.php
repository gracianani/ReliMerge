<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeatNetHourlyPlannedPerdict extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('total_net_hourly', function($table)
        {
            $table->float('heat_planned');
            $table->float('heat_perdict');
        //    $table->renameColumn('heat', 'heat_actual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('total_net_hourly', function($table)
        {
            $table->dropColumn('heat_planned');
            $table->dropColumn('heat_perdict');
          //  $table->renameColumn('heat_actual', 'heat');
        });
    }
}
