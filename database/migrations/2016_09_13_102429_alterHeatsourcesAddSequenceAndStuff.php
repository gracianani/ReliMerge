<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHeatsourcesAddSequenceAndStuff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('heatsources', function($table)
        {
            $table->string('heat_source_num', 100)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('address', 512)->nullable();
            $table->smallInteger('year_of_built')->nullable();
            $table->float('area')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('admin', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->boolean('is_gas')->nullable();
            $table->boolean('inner_or_outer')->nullable();
            $table->smallInteger('district_id')->nullable();
            $table->boolean('is_whole')->nullable();
            $table->float('heat_capacity')->nullable();
            $table->float('max_hourily_heat_capacity')->nullable();
            $table->float('max_daily_hourily_heat_capacity')->nullable();
            $table->float('max_water_cycle')->nullable();
            $table->float('additional_water')->nullable();
            $table->float('max_inst_additional_water')->nullable();
            $table->float('max_daily_additional_water')->nullable();
            $table->float('max_monthly_additional_water')->nullable();
            $table->float('daily_gas_usage')->nullable();
            $table->float('hourly_gas_usage')->nullable();
            $table->float('num_of_ovens')->nullable();
            $table->float('num_of_gas')->nullable();
            $table->float('oven_heat_capacity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('heatsources', function($table)
        {
            $table->dropColumn('heat_source_num');
            $table->dropColumn('name');
            $table->dropColumn('address');
            $table->dropColumn('year_of_built');
            $table->dropColumn('area');
            $table->dropColumn('company_id');
            $table->dropColumn('admin');
            $table->dropColumn('phone');
            $table->dropColumn('is_gas');
            $table->dropColumn('inner_or_outer');
            $table->dropColumn('district_id');
            $table->dropColumn('is_whole');
            $table->dropColumn('heat_capacity');
            $table->dropColumn('max_hourily_heat_capacity');
            $table->dropColumn('max_daily_hourily_heat_capacity');
            $table->dropColumn('max_water_cycle');
            $table->dropColumn('additional_water');
            $table->dropColumn('max_inst_additional_water');
            $table->dropColumn('max_daily_additional_water');
            $table->dropColumn('max_monthly_additional_water');
            $table->dropColumn('daily_gas_usage');
            $table->dropColumn('hourly_gas_usage');
            $table->dropColumn('num_of_ovens');
            $table->dropColumn('num_of_gas');
            $table->dropColumn('oven_heat_capacity');
        });
    }
}
