<?php namespace App\Services;

use App\Entities\Block;

class DashboardService
{
	public function getBlock( $block_name )
	{
		$block = Block::where('module', $block_name)->first();
        $heatsource_block = $block->blockable;
        return $heatsource_block;
	}
}