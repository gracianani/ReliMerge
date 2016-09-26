<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlockBlockUnitParent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('block_units', function($table)
        {
            $table->integer('parent_id')->unsingned()->nullable();
            $table->foreign('parent_id')->references('id')->on('block_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('block_units', function ($table)
        {
            $table->dropColumn('parent_id');
        });
    }
}
