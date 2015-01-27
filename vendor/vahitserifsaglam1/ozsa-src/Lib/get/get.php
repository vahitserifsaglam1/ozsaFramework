<?php
namespace Lib\get;
class get{

    public  static function variable($name){
         if(isset($GLOBALS[$name]))
         {
             return $GLOBALS[$name];
         }else{
             return false;
         }
    }
    public  static function postVal($val = false){
      global $_POST;
      if($val){
          return array_filter($_POST,"security_render");
      }else{
          return $_POST;
      }
    }
    public static function content($file)
    {
        return file_get_contents($file);
    }
    public static  function getVal($val = false){
        global $_GET;
        if($val){
            return array_filter($_GET,"security_render");
        }else{
            return $_GET;
        }
    }

    public static function serializer($get = array(),$security = false){
        if(is_array($get)){
            $d = "";
            foreach($get as $key => $value){
                if($security){
                    $key = security::render($key);
                    $value = security::render($value);
                }
                $d .= "$key=$value&";
            }
            $d = rtrim($d,"&");
            return $d;
        }
        else{
            return false;
        }
    }
}
 ?>