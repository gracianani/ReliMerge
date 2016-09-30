<?php

return array(

	'title' => '热力站模块设置',

	'single' => '热力站模块',

	'model' => 'App\Entities\StationBlock',

	'columns' => array(
		'id',
		'title' 
	),

	'edit_fields' => array(
		'block_id',
		'role_id'
	)
);