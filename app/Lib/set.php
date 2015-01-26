<?php 
 
 class set{
    /**
     * @param $name
     * @param $value
     * @return string
     */
    public  static function variable($name,$value){
        $GLOBALS[$name] = $value;
        return $name;
    }

    /**
     * @param array $array
     * @return object
     */
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
    /**
     * @param $object
     * @return array
     */
    public  static  function ObjectToArray($object){
        if(is_object($object)){
            return (array) $object;
        }else {
            error::newError("HATA : $object bir obje değil");
        }
    }
}
 ?>