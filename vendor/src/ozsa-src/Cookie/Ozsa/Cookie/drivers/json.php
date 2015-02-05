<?php

  class jsonCookie
  {
      public static function set($name,$value,$time = 1800)
      {

          $time = time()+$time;
          $array = array('time' => $time);
          $array['content'] = $value;
          $array = json_encode($array);

          self::createSesssionFile($name,$array,".json");

      }
      public static function get($name)
      {

          $don =  self::readCookieFile($name,".json");
          $value =  json_decode($don);
          $file = self::createFileName($name).".json";
          $filetime = filemtime($file);
          if($filetime>$value->time)
          {
              self::deleteCookieJson($name);
          }else{
              return $value->content;
          }
      }

      public static function delete($name)
      {
          $name = self::createFileName($name);
          $file = self::$CookieFolder."/".$name.".json";
          if(file::check($file))  file::delete($file);else return false;
      }
      public static function flush()
      {
          $ara = file::scanType(self::$CookieFolder,"json");
          foreach($ara as $key)
          {
              unlink(self::$CookieFolder."/".$key);
          }
      }
      public static function createSesssionFile($name,$ext,$content)
      {
          $name = self::createFileName($name);

          $file = self::$CookieFolder."/".$name.$ext;

          if(!file_exists($file))
          {
              touch($file);
              chmod($file,0777);
              file::setContent($file,$content);
          }else{
              file::setContent($file,$content);
          }

          return $file;

      }
      public static function readCookieFile($name,$ext)
      {
          $name = self::createFileName($name);

          $file = self::$CookieFolder."/".$name.$ext;

          $oku = file::getContent($file,false);

          if($oku) return $oku['content'];else return false;
      }
      public static function createFileName($name)
      {
          $typ = self::$nameHast;

          return $typ($name);
      }
  }