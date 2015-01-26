<?php
class Once
{
    public static function  __callStatic($name,$params = array())
    {

        $file = $name."/".$params[0];
        if(!strstr($params[0],"."))
        {
            $file .= ".php";
        }
        return include $file;
    }
}
  class File{
      public static function open($path)
      {
          if(file_exists($path))
          {
               $ac = fopen($path,"r");
               $oku = fgets($ac);
               fclose($ac);
              return $oku;
          }else{
              error::newError("$path Böyle bir dosya bulunamadı");
              return false;
          }
      }
      public  static function write($path,$write)
      {
          if(file_exists($path)){
              $ac = fopen($path,"w");
              $yaz = fwrite($ac,$write);
              fclose($ac);
          }else{
              error::newError("$path Böyle bir dosya bulunamadı");
          }

      }
      public static function delete($path)
      {
          if(file_exists($path)){ if(is_dir($path))rmdir($path);else unlink($path);}else{return false;}
      }
      public static function check($path)
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
