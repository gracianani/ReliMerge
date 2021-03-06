<?php

use App\Entities\DisplayValue;
use App\ConstDefine;

return array(

	'title' => '模块设置',

	'single' => '模块',

	'model' => 'App\Entities\Block',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'role_id' => array(
			'title' => '角色',
			'output' => function($value)
			{
				return ConstDefine::getRoleName($value);
			}
		),
		'display_direction_id' => array(
			'title' => '方向',
			'output' => function($value){
				switch ($value) {
		    		case DisplayValue::HORIZONTAL:
		    			return '水平';
		    		case DisplayValue::VERTICAL:
		    			return '垂直';
		    	}
			}
		),
		'display_dropdown_id' => array(
			'title' => '叠加方式',
			'output' => function($value){
				switch ($value) {
		    		case DisplayValue::ALL:
		    			return '全部';
		    		case DisplayValue::DROPDOWN:
		    			return '下拉框';
		    	}
			}
		),
		'display_graph_id' => array(
			'title' => '展示方式',
			'output' => function($value)
			{
				switch ($value) {
		    		case DisplayValue::LINE :
		    			return '折线';
		    		case DisplayValue::BAR;
		    			return '柱状图';
		    		case DisplayValue::RADAR :
		    			return '网状图';
		    		case DisplayValue::POLAR_AREA;
		    			return '扇形';
		    		case DisplayValue::PIE :
		    			return '饼图';
		    		case DisplayValue::DOUGHNUT;
		    			return '多纳圈';
		    		case DisplayValue::BUBBLE;
		    			return '泡泡';
		            case DisplayValue::TABLE;
		                return '表格';
		    	}
			}
		),
		'title' => array(
			'title' => '模块名',
		),
		'module',
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'role' => array(
			'title' =>'角色',
			'type' => 'relationship',
			'name_field' => 'name',
			'value_field' => 'id'
		),
		'size' => array(
			'title' => '大小',
			'type' => 'enum',
			'options' => array(
				'25', '50', '75', '100'
			)
		),
		'sequence' => array(
			'title' => '顺序',
			'type' => 'number'
		),
		'title' => array(
			'title' => '标题',
			'type' => 'text'
		),
		'direction' => array(
			'title' => '方向',
			'type' => 'relationship',
			'name_field' => 'name',
			'value_field' => 'id'
		),
		'stack' => array(
			'title' => '叠加方式',
			'type' => 'relationship',
			'name_field' => 'name',
			'value_field' => 'id'
		),
		'graph' => array(
			'title' => '展示方式',
			'type' => 'relationship',
			'name_field' => 'name',
			'value_field' => 'id'
		),
		'blockable_id' => array(
			'title' => 'id',
			'type' => 'number'
		),
		'blockable_type' => array(
			'title' => '类型',
			'type' => 'enum',
			'options' => array(
				'App\Entities\HeatSourceBlock', 
				'App\Entities\StationBlock',
				'App\Entities\StationDashboardBlock',
				'App\Entities\DashboardValueBlock',
				'App\Entities\DashboardSeriesBlock',
				'App\Entities\DashboardCompareBlock',
				'App\Entities\Company'
			)
		),
		'module' => array(
			'title' => '模块名称',
			'type' => 'text'
		)
	),

	'filters' => array(
		'module' => array(
			'title' => '模块',
		),
	)

);