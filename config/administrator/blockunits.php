<?php

return array(

	'title' => '单位设置',

	'single' => '单位',

	'model' => 'App\Entities\BlockUnit',

	/**
	 * The display columns
	 */
	'columns' => array(
		'title' => array(
			'title' => '显示名称'
		),
		'property_name' => array(
			'title' => '数据库列名'
		),
		'unit' => array(
			'title' => '单位'
		)
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'title' => array(
			'title' => '显示名称'
		),
		'property_name' => array(
			'title' => '数据库列名'
		),
		'unit' => array(
			'title' => '单位'
		),
		'is_sortable' => array(
			'title' => '是否可排序',
			'type' => 'bool'
		),
		"is_filterable" => array(
			'title' => '是否可筛选',
			'type' => 'bool'
		),
		'is_visible' => array(
			'title' => '是否能显示',
			'type' => 'bool'
		),
		"is_editable" => array(
			'title' => '是否可编辑',
			'type' => 'bool'
		),
		"filter_type" => array(
			'title' => '筛选类型',
			"type" => 'enum',
			'options' => array(
				'range','dropdown','text'
			)
		),
		'sequence' => array(
			'title' => '顺序',
			'type' => 'number'
		),
		"blocks" => array(
			'title' => '相关模块',
			'type' => 'relationship',
			'name_field' => 'title',
			'value_field' => 'id'
		),
		'parent' => array(
			'title' => '父block',
			'type' => 'relationship',
			'name_field'=>'title',
			'value_field' => 'id'
		)
	),

	'filters' => array(
		'title' => array(
			'title' => '显示名称',
		),
	),

);