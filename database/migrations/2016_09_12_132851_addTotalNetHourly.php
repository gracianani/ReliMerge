<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalNetHourly extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_net_hourly', function($table)
        {
            $table->increments('id');
            $table->float('heat');
            $table->integer('total_net_recent_id')->unsigned();
            $table->foreign('total_net_recent_id')->references('ItemID')->on('TotalNetRecent');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('total_net_hourly');
    }
}
