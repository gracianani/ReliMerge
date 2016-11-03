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

    public function applyCustomSettings($blocks, $module_name, $user=null)
    {
        if(!$user->settings->contains('module_name', $module_name))
        {
            return $blocks;
        }
        $user_setting = $user->settings->first( function($value, $key) use($module_name) {
            return $value->module_name ==  $module_name;
        });

        $setting_value = collect( json_decode($user_setting->setting_value, true) );
        $blocks->transform(
            function ($item, $key) use($setting_value) {
            if($setting_value->contains("id", $item["id"]))
            {
                $id = $item["id"];
                $the_setting = $setting_value->first( function($value, $key) use( $id ) {
                    return $value["id"] ==  $id;
                });
                $item["size"] = $the_setting["size"];
                $item["sequence"] = $the_setting["sequence"];
                $item["is_visible"] = $the_setting["is_visible"];
            }
            else {
            	$item["is_visible"] = false;
            }
            return $item;
        });
        return $blocks->sortBy('sequence')->where('is_visible', true)->values();
    } 

	public function getBlock( $block_name)
	{
		$block = Block::where('module', $block_name)->first();
        $blockable = $block->blockable;
        return $blockable;
	}


	public function getBlocks( $block_name , $user= null)
	{
		if( $user != null)
		{
			$role_ids = $user->role_ids;
			$blocks = Block::where('module', $block_name)->
				whereIn('role_id', $role_ids)->
				orderBy('sequence')->get();
			$blocks = $this->applyCustomSettings($blocks, $block_name, $user);
		}
		else 
		{
			$blocks = Block::where('module', $block_name)->orderBy('sequence')->get();
		}
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