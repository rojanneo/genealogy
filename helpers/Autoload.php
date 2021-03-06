<?php

if(!function_exists('loadHelper'))
{
	function loadHelper($filename)
	{
		include 'helpers/'.$filename.'.php';
	}
}
if(!function_exists('getModel'))
{
	function getModel($filename)
	{
		require_once('models/'.$filename.'Model.php');
		$modelName = $filename.'Model';
		$model = new $modelName();
		return $model;
	}
}

if(!function_exists('loadView'))
{
	function loadView($filename)
	{
		include('views/'.$filename);
	}
}

if(!function_exists('get_content'))
{
	function get_content($string) 
	{

	//$string = "<h2>Test{{config identifier=telephone}},the people are very nice1 {{config identifier=footer_text}}, {{config identifier=zip}}</h2>";
		$regex = "/\{{(.*?)\}}/";
		preg_match_all($regex, $string, $matches);
		for($i = 0; $i < count($matches[1]); $i++)
		{
    		$match = $matches[1][$i];
    		$code = '{{'.$match.'}}';
    		$match = explode(' ',$match); 
    		$value = false;
    		if($match[0] == 'config')
    		{
      			 $identifier = explode('=',$match[1]);
        		if(!isset($identifier[1]))
           		 $value = 'wrong short code';
        		else
        		{
           		 	$value = getModel('configuration')->getConfigValue($identifier[1]);
           			if($value)
           			{
              		$string = str_replace($code, $value, $string);
	              	}
            		else
             		 $string = str_replace($code, '{{INVALID IDENTIFIER}}', $string);

        		}
    		}
    		else if($match[0] == 'widgets')
    		{
    			$identifier = explode('=',$match[1]);
        		if(!isset($identifier[1]))
           		 $value = 'wrong short code';
        		else
        		{
           		 	$value = getModel('widgets')->addWidgetpostcontent($identifier[1]);
           		 	$value = get_content($value);
           			if($value)
           			{
              		$string = str_replace($code, $value, $string);
	              	}
            		else
             		 $string = str_replace($code, '{{INVALID IDENTIFIER}}', $string);

        		}
    		}

		}
	return $string;

	}
}

if(!function_exists('checkParentIfAreNotSame'))
{
	function checkParentIfAreNotSame($x_parent_MF,$y_parent_MF)
	{
            if($x_parent_MF['m']==0){ $x_parent_MF['m']=-1; }
            if($x_parent_MF['f']==0){ $x_parent_MF['f']=-2; }
            if($y_parent_MF['m']==0){ $y_parent_MF['m']=-3; }
            if($y_parent_MF['f']==0){ $y_parent_MF['f']=-4; }
            if(($x_parent_MF['m']==$y_parent_MF['m'])||($x_parent_MF['f']==$y_parent_MF['f'])||($x_parent_MF['m']==$y_parent_MF['f'])||($x_parent_MF['f']==$y_parent_MF['m']))
            {
                return false;
            }
            else
            {                          
                return true;
            }
                
	}
}
?>