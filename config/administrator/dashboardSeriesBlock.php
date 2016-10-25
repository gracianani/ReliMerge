<?php
use App\Entities\DisplayValue;

return array(

	'title' => '实时模块设置',

	'single' => '实时模块',

	'model' => 'App\Entities\DashboardSeriesBlock',

	'columns' => array(
		'id',
		'from' => array(
			'title' => '开始日期'
		),
		'to' => array(
			'title' => '结束日期'
		),
		'from_offset' => array(
			'title' => '开始时间'
		),	
		'to_offset' => array(
			'title' => '结束时间'
		),		
		'role_id' => array(
			'title' => '角色'
		),
		'modelable_id' => array(
			'title' => '实例ID'
		),
		'modelable_type' => array(
			'title' => '实例Type'
		)
	),

	'edit_fields' => array(
		'is_filter_collection' => array(
			'title' => '是否对时间进行筛选( true时 from_offset, to_offset, hourly_from_offset, hourly_to_offset 有效）',
			'type' => 'bool'
		),
		'from_offset' => array(
			'title' => '开始日期Offset',
			'type' => 'datetime'
		),
		'to_offset' => array(
			'title' => '结束日期Offset',
			'type' => 'datetime'
		),
		'has_hourly_function' => array(
			'title' => '是否有小时函数（true时， 对小时函数和时间进行筛选）',
			'type' => 'bool'
		),
		'hourly_function_name' => array(
			'title' => '小时函数名称（仅对小时函数为=true时有效）',
			'type' => 'text'
		),
		'hourly_from_offset' => array(
			'title' => '开始时间Offset',
			'type' => 'datetime'
		),
		'hourly_to_offset' => array(
			'title' => '结束时间Offest',
			'type' => 'datetime'
		),
		'role_id' => array(
			'title' => '角色'
		),
		'group_by' => array(
			'title' => '聚合所用Attribute',
			'type' => 'text'
		),
		'modelable_id' => array(
			'title' => '实例ID'
		),
		'modelable_type' => array(
			'title' => '实例Type'
		),
		'block_id' => array(
			'title' => 'block id'
		)
	),

);