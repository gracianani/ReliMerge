<?php

use App\Entities\DisplayValue;

return array(

	'title' => '模块设置',

	'single' => '模块',

	'model' => 'App\Entities\Block',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
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
			'title' => '叠加方式'
		),
		'display_graph_id' => array(
			'title' => '展示方式'
		),
		'title',
		'module',
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
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
		'display_direction_id' => array(
			'title' => '方向',
			'type' => 'enum',
			'options' => array(
				'1',
				'2'
			)
		),
		'display_dropdown_id' => array(
			'title' => '叠加方式',
			'type' => 'enum',
			'options' => array(
				'1',
				'2'
			)
		),
		'display_graph_id' => array(
			'title' => '展示方式',
			'type' => 'enum',
			'options' => array(
				'1',
				'2'
			)
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
				'App\Entities\HeatRecentBlock',
				'App\Entities\StationBlock'
			)
		),
		'module' => array(
			'title' => '模块名称',
			'type' => 'text'
		)
	),

);