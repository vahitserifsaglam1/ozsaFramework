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
    public static function obje($array = array()){
         if(is_array($array)){
              return (object) $array;
         }else{
             error::newError("HATA :  $array Bir dizi değil");
         }
    }

    /**
     * @param $object
     * @return array
     */
    public  static  function arry($object){
        if(is_object($object)){
            return (array) $object;
        }else {
            error::newError("HATA : $object bir obje değil");
        }
    }
}
 ?>