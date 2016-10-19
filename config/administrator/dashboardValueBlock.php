<?php
use App\Entities\DisplayValue;

return array(

	'title' => '数值模块设置',

	'single' => '数值模块',

	'model' => 'App\Entities\DashboardValueBlock',

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

	/**
	 * The editable fields
	 */
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
		)
	),

);