<?php

 class jq {
    public static $queryString;

     public static function init()
     {
          echo  "<script> \n
             $(function(){ ";
             echo self::$queryString;
          echo "}); </script>";
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
             var data = '".$string."'

             $.post(url,data,function (data){
                $('".$returnid."').html(data);
             })

           ";
           return ($return)?  $metin : self::$queryString .= $metin;
      }
     public static function Func($name,$variables,$func,$return = true)
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
         return ($return)? $metin : self::$queryString .= $metin;
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
             var data = '".$string."'

             $.get(url,data,function (data){
                $('".$returnid."').html(data);
             })

           ";
            return ($return)? $metin : self::$queryString .= $metin;
     }

     public static function addClass($class,$newclass,$return = false)
     {
         $metin =  "
               $('".$class."').addClass('".$newclass."');
          ";
          return ($return)? $metin : self::$queryString .= $metin;
     }

     public static function removeClass($class,$removedclass,$return = false)

     {
         $metin =  "

            $('".$class."').removeClass('".$removedclass."');

         ";
          return ($return)? $metin : self::$queryString .= $metin;
     }

     public static function toggleClass($class,$toggleClass,$return = false)
     {
      $metin = "
          $('".$class."').toggleClass('".$toggleClass."');
      ";
         return ($return)? $metin : self::$queryString .= $metin;
     }

     /**
     * @param $id
     * @param array $animate
     */
     public static function animate($id,$animate = array())
     {

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
          return ($return)? $metin : self::$queryString .= $metin;
     }

     public static function setAttr($id,$attr,$value,$return = false)
     {
          $metin =  "
           $('".$id."').attr('".$id."','".$attr."','".$value."');
          ";
          return ($return)? $metin :  self::$queryString .= $metin;
     }
     /**
     * @param $id
     * @param $html
     */

     public static function html($id,$html)

     {

          $metin = "
           $('".$id."').html('".$html."');";
           
            return ($return)? $metin :  self::$queryString .= $metin;

     }

 }


?>