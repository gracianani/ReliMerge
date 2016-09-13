<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlockunitable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('heatsource_blocks')) 
        {
            Schema::create('heatsource_blocks', function($table)
            {
                $table->increments('id');
                $table->integer('block_id')->unsigned();
                $table->foreign('block_id')->references('id')->on('blocks');
                $table->tinyInteger('role_id');
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
        Schema::drop('heatsource_blocks');
    }
}
