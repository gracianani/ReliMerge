<?php namespace App\Services;

use App\Entities\Station;
use App\Entities\StationRecent;
use App\ConstDefine;

class StationService
{
	public function fetchAll()
	{
		return Station::all();
	}

	public function fetAllRealtime($value='')
	{
		return StationRecent::all();
	}

	public function fetch($id)
	{
		return Station::find($id);
	}

	public function updateControl($station, $change_data_items)
	{

		//重新排序
		foreach ($change_data_items as $change_data_item) {
			$change_item_id = $change_data_item["change_item_id"];
			switch ($change_item_id) {
				case 'value':
					# code...
					break;
				
				default:
					# code...
					break;
			}
			# code...
		}


		//修改二次
		if($parameter["group_id"] > 0)
		{
			$station->station_auto_control->valve = $parameter["value"];
			//修改温控曲线
			if($parameter["value"] == 3 || )
			{

			}
			//修改时段曲线
			if($parameter["value"] == 4 || $parameter["value"] == 5)
			{

			}
			// 修改低温运行
			if($parameter["value"] == 7)
			{

			}
			// 修改低温
			if($parameter["value"] == 8)
			{
			}

			// 修改为手动
			if($parameter["value"] == 10)
			{

			}

		}

		//修改全站一次
		else {

		}
	}
}