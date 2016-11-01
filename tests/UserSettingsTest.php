<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserSettingsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserSerttings()
    {
    	$block = ReliDashboard::getBlock('station_recent');
    	$block->station_recent_block_array;
    }
}
