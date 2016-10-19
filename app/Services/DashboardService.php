<?php namespace App\Services;

use App\Entities\Block;

class DashboardService
{
	public function getBlock( $block_name )
	{
		$block = Block::where('module', $block_name)->first();
        $blockable = $block->blockable;
        return $blockable;
	}

	public function getBlocks( $block_name )
	{
		$blocks = Block::where('module', $block_name)->orderBy('sequence')->get();
		return $blocks;
	}
}