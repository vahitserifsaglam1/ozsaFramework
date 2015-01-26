<?php

 class Jquery {
    public static $queryString;

     public static function extract()
     {
          echo  "<script> \n
             $(function(){ ";
             echo self::$queryString;
          echo "}); </script>";
     }
      public static function clear()
      {
        self::$queryString = "";
      }
      public static function post($url,$formid,$returnid = ".sonuc",$return = false){ 

        if(is_array($formid))
      {
          $d = "";
          foreach ($formid as $key => $value)
          {
              $d .= "$key=$value&";
          }
          $string = rtrim($d,"&");
      }else{
          $string = "$('".$formid."').serialize()";
      }
          $metin ="

             var url = '".$url."';
             var data = '".$string."';

             $.post(url,data,"; 
              if(strstr($returnid, "{")){
                $metin .= $returnid.")";
              }else{
                   $metin  .= "$('".$returnid."').html(data);";
              }
                 if($return) return $metin;else self::$queryString .= $metin;
             }
           
          
     public static function func($name,$variables,$func,$return = true)
     {
         if(is_array($variables)){
             foreach($variables as $key)
             {
                  $variables = "";
                  $variables .= "$key,";
             }
             $variables = rtrim($variables,",");
         }
         $metin = "function $name($variables){
           $func
         }";
         if($return) return $metin;else self::$queryString .= $metin;
     }
     public static function get($url,$formid,$returnid = ".sonuc",$return = false)
     {
          if(is_array($formid))
          {
              $d = "";
              foreach ($formid as $key => $value)
              {
                  $d .= "$key=$value&";
              }
              $string = rtrim($d,"&");
          }else{
              $string = "$('".$formid."').serialize()";
          }

         $metin ="

            var url = '".$url."';
             var data = '".$string."';

             $.get(url,data,"; 
              if(strstr($returnid, "{")){
                $metin .= $returnid.")";
              }else{
                   $metin  .= "$('".$returnid."').html(data);";
              }
                  if($return) return $metin;else self::$queryString .= $metin;
             }
          
     public static function addClass($class,$newclass,$return = false)
     {
         $metin =  "
               $('".$class."').addClass('".$newclass."');
          ";
          if($return) return $metin;else self::$queryString .= $metin;
     }

     public static function removeClass($class,$removedclass,$return = false)

     {
         $metin =  "

            $('".$class."').removeClass('".$removedclass."');

         ";
          if($return) return $metin;else self::$queryString .= $metin;
     }

     public static function toggleClass($class,$toggleClass,$return = false)
     {
      $metin = "
          $('".$class."').toggleClass('".$toggleClass."');
      ";
          if($return) return $metin;else self::$queryString .= $metin;
     }
     /**
     * @param $url
     * @param $returnid
     */
     public function load($url,$returnid,$return = false)
     {
         $metin =  "
          $('".$returnid."').load('".$url."');
         ";
           if($return) return $metin;else self::$queryString .= $metin;
     }

     public static function setAttr($id,$attr,$value,$return = false)
     {
          $metin =  "
           $('".$id."').attr('".$id."','".$attr."','".$value."');
          ";
           if($return) return $metin;else self::$queryString .= $metin;
     }
     /**
     * @param $id
     * @param $html
     */

     public static function html($id,$html,$return = false)

     {

          $metin = "
           $('".$id."').html('".$html."');";
           
             if($return) return $metin;else self::$queryString .= $metin;
     }

 }


?>
