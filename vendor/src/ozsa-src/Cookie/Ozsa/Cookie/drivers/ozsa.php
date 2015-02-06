<?php

  class ozsaCookie
  {

      public static function set($name,$value,$time=false)
      {

          if(!self::$OzsaIncluded) self::init();
          $time = time()+$time;
          $array = array();
          $array['time'] = $time;
          $array['content'] = $value;
          $value = Ozsa::encode($array);

          self::createCookieFile($name,".ozsa",$value);

      }

      public static function get($name)
      {
          if(!self::$OzsaIncluded) self::init();
          return Ozsa::decode(self::readCookieFile($name,".ozsa"));
      }

      public static function delete($name)
      {
          $name = self::createFileName($name);
          $file = self::$CookieFolder."/".$name.".ozsa";
          if(file::check($file))  file::delete($file);else return false;
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
      public function flush()
      {
          $ara = file::scanType(self::$CookieFolder,"ozsa");
          foreach($ara as $key)
          {
              unlink(self::$CookieFolder."/".$key);
          }
      }
      public static function createCookieFile($name,$ext,$content)
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


  }