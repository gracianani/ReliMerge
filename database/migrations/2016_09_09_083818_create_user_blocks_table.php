<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('blocks')) 
        {
            Schema::create('blocks', function($table)
            {
                $table->increments('id');
                $table->smallInteger('size');
                $table->smallInteger('sequence');
                $table->string('title', 255);
                $table->tinyInteger('display_direction_id'); // horizontal or verticle
                $table->tinyInteger('display_dropdown_id'); // dropdown or all
                $table->tinyInteger('display_graph_id');  // line / pie / dougnut ... 
                $table->morphs('blockable');
            });
        }

        if (!Schema::hasTable('heat_recent_blocks')) 
        {
            Schema::create('heat_recent_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->timestamp('from');
                $table->timestamp('to');
                $table->boolean('is_realtime');
                $table->time('interval');
                $table->tinyInteger('role_id');
            });
        }

        if (!Schema::hasTable('heat_perdict_blocks')) 
        {
            Schema::create('heat_perdict_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->tinyInteger('role_id');
                $table->date('date');
                $table->time('interval');
            });
        }   

        if(!Schema::hasTable('cost_blocks'))
        {
            Schema::create('cost_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->tinyInteger('role_id');
                $table->date('from');
                $table->date('to');
                $table->time('interval');
            });
        }
        
        if(!Schema::hasTable('heat_index_blocks'))
        {
            Schema::create('heat_index_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->tinyInteger('role_id');
                $table->date('at');
            });
        }

        if(!Schema::hasTable('temperature_heat_blocks'))
        {
            Schema::create('temperature_heat_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->tinyInteger('role_id');
                $table->date('from');
                $table->date('to');
                $table->time('interval');
            });
        }
        
        if(!Schema::hasTable('inst_blocks'))
        {
            Schema::create('inst_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->tinyInteger('role_id');
            });
        }

        if(!Schema::hasTable('area_blocks'))
        {
            Schema::create('area_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->tinyInteger('role_id');
                $table->date('from');
                $table->date('to');
                $table->time('interval');
            });
        }

        if(!Schema::hasTable('stat_blocks'))
        {
            Schema::create('stat_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->tinyInteger('role_id');
                $table->date('from');
                $table->time('interval');
                $table->date('to');
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
        Schema::drop('stat_blocks');
        Schema::drop('area_blocks');
        Schema::drop('inst_blocks');
        Schema::drop('temperature_heat_blocks');
        Schema::drop('heat_index_blocks');
        Schema::drop('cost_blocks');
        Schema::drop('heat_perdict_blocks');
        Schema::drop('heat_recent_block');
        Schema::drop('blocks');
    }
}
