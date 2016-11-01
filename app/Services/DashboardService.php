<?php namespace App\Services;

use App\Entities\Block;

use Validator;

class DashboardService
{
	public function getValidationRules()
	{
		return $this->validate_rules;
	}

	public function getValidationMessages()
	{
		return $this->validation_messages;
	}

	private $validate_rules = [
        'property_name' => 'required|string',
        'is_visible' => 'required|boolean',
   	];

   	private $validation_messages = [
        'required' => '缺少 :attribute 参数.',
        'boolean' => ':attribute 类型错误，只接受0或1'
    ];

	public function getBlock( $block_name )
	{
		$block = Block::where('module', $block_name)->first();
        $blockable = $block->blockable;
        return $blockable;
	}

	public function getBlocks( $block_name )
	{
		$blocks = Block::where('module', $block_name)->orderBy('sequence')->get();
		return $blocks;
	}

	public function getHeader( $block_name, $property_name, $header_display_type )
	{
		$block = $this->getBlock($block_name);
		$header = $block->block->headerBlockUnits->where('property_name','=', $property_name)->first()->{$header_display_type};
		return $header;
	}

	public function validate( $data )
	{
        foreach ($data as $data_item) {
			$validator = Validator::make(
	            $data_item , 
	            $this->validate_rules, 
	            $this->validation_messages
	        );
        	if ($validator->fails()) {
	            return array(
	            	'error' => true,
	            	'error_message' =>  $validator->errors()
	            );
	        }
        }

    	return array(
    		'error' => false
    	);
	}

	public function saveSettings( $module, $data, $user = null)
	{
		$user_setting = $user->settings->where('module_name' , $module)->first();
		$user_setting->setting_value = json_encode($data);
		$user_setting->save();
	}

}