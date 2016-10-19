<?php
use App\Entities\DisplayValue;

return array(

	'title' => '实时模块设置',

	'single' => '实时模块',

	'model' => 'App\Entities\DashboardSeriesBlock',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'from' => array(
			'title' => '开始时间'
		),
		'to' => array(
			'title' => '结束时间'
		),
		'is_realtime' => array(
			'title' => '实时'
		),
		'interval' => array(
			'title' => '间隔'
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

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'from' => array(
			'title' => '开始时间',
			'type' => 'datetime'
		),
		'to' => array(
			'title' => '结束时间',
			'type' => 'datetime'
		),
		'is_realtime' => array(
			'title' => '实时',
			'type' => 'bool'
		),
		'interval' => array(
			'title' => '间隔',
			'type' => 'time'
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

);