<?php 
   
    class Request 
    {
    	public static function post($url,$fields,$files = array(),$options = array())
    	{

    		$request = array($url,$fields);
            if( count($files) > 1)
            {
            	$request[] = $files;
            }
            if( count($options) )
            {
            	$request[]=$options;
            }
            
            $response = call_user_func_array('http_post_fields', $request);
            $n = preg_match("/HTTP\/1.1 302 Found/", $response, $matches);
           if($n<1) return true;
           else    return false;
    	}
    	public static function get($url)
    	{
    		$response = file_get_contents($url);
    		return $response;
    	}
    }      
  
 ?>