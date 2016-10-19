<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDashboardTableBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('dashboard_table_blocks'))
        {
            Schema::create('dashboard_table_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->tinyInteger('role_id');
                $table->date('at');
                $table->morphs('modelable');
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
        if(Schema::hasTable('dashboard_table_blocks'))
        {
            Schema::drop('dashboard_table_blocks');
        }
    }
}
