<?php
class set{
    public  static function variable($name,$value){
        $GLOBALS[$name] = $value;
        return $name;
    }

    public static function arrayToObject($array = array()){
        if(is_array($array)){
            return (object) $array;
        }else{
            error::newError("HATA :  $array Bir dizi değil");
        }
    }
    public static function content($file,$content)
    {
        $yaz = file_put_contents($file,$content);
        return $yaz;
    }
    public  static  function ObjectToArray($object){
        if(is_object($object)){
            return (array) $object;
        }else {
            error::newError("HATA : $object bir obje değil");
        }
    }
}
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