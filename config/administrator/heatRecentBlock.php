<?php
use App\Entities\DisplayValue;

return array(

	'title' => '供热实时表设置',

	'single' => '供热实时表',

	'model' => 'App\Entities\HeatRecentBlock',

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
			'title' => '间隔'
		),
		'role_id' => array(
			'title' => '角色'
		)
	),

);