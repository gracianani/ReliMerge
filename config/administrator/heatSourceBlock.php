<?php

return array(

	'title' => '热源模块设置',

	'single' => '热源模块',

	'model' => 'App\Entities\HeatSourceBlock',

	'columns' => array(
		'id',
		'title' => array(
			'title' => '显示名称',
			'output' => function( $value)
			{
				return $value;
			}
		)
	),

	'edit_fields' => array(
		'block_id',
		'role_id'
	)
);