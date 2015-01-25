<?php
  class Once
  {
     public static function  __callStatic($name,$params = array())
     {
        $file = $name."/".$params[0];
        return include $file;
     }
  }
  class Fıle{
      public static function readFile($path)
      {
          if(file_exists($path))
          {
               $ac = fopen($path,"r");
               $oku = fgets($ac);
               fclose($ac);
              return $oku;
          }else{
              error::newError("$path Böyle bir dosya bulunamadı");
          }
      }
      public  static function writeFile($path,$write)
      {
          if(file_exists($path)){
              $ac = fopen($path,"w");
              $yaz = fwrite($ac,$write);
              fclose($ac);
          }else{
              error::newError("$path Böyle bir dosya bulunamadı");
          }

      }
      public static function checkDir($path)
      {
         if(file_exists($path))
           {
             if(is_dir($path))
             {
               return true;
             }else{
              return false;
             }
           }else{
            error::newError("$path dosyası bulunamadı");
            return false;
           }
      }
    public static function __callStatic($name,$params = array())
    {
       if(function_exists($name))
       {
        if( count($params) > 1)
        {
          return call_user_func_array($name, $params);
        }else{
          return $name();
        }
       }
    }
  }
