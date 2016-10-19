<?php
use App\Entities\DisplayValue;

return array(

	'title' => '表格模块设置',

	'single' => '表格模块',

	'model' => 'App\Entities\DashboardTableBlock',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'block_id' => array(
			'title' => '模块ID',
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
		'block_id' => array(
			'title' => '模块ID',
			'type' => 'number'
		),
		'role_id' => array(
			'title' => '角色'
		),
		'modelable_id' => array(
			'title' => '实例ID',
			'type' => 'number'
		),
		'modelable_type' => array(
			'title' => '实例Type',
			'type' => 'text'
		),
		'at' => array(
			'title' => '日期',
			'type' => 'date'
		)
	),
);