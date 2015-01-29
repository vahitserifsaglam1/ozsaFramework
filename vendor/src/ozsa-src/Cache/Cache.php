<?php

  class Cache {

      private  $_cache;

     public function __construct()
     {
           $cacheFile = APP_PATH .'Stroge/Cache';
           if(!file_exists($cacheFile)) error::newError(APP_PATH.'Stroge/Cache/ dosyası bulunamadı lütfen oluşturun');
           if(extension_loaded('memcache')){
               $this->_cache  = new Memcache; $this->_cache->connect('127.0.0.1', 11211);
           }    else
           {
               if(!is_writeable($cacheFile)) \error::newError($cacheFile ."yazılabilir bir dosya değil");
               $this->_cache = new OzsaCache($cacheFile);
           }
     }

  }

  class OzsaCache{
      private  $cache;
      private  $cacheType;
      public   $cacheFiles;
      public $newCacheFile;
      public $cacheFile;
      public function __construct($path)
      {
          $this->cacheFile = $path;
      }
      public function get($name)
      {
          $cacheFiles = $this->cacheFiles;
          $file =$cacheFiles[$name]['newFilePath'];
          $time = $cacheFiles[$name]['time'];
          if(file_exists($file)){
              $value = file_get_contents($file);
              $value = json_decode($value);

              if( is_object($value) )
              {

                  if(filemtime($file) < time() - $value->time){return false; } else{

                      return (array) $value;
                  }
              }
          }else{return false;}
      }
      public  function  check($name){
          $file = $this->cacheFiles[$name]['newFilePath'];
          return (file_exists($file)) ? true:false;
      }
      public function set($name,$value,$time = 3600)
      {
          $newCacheFile = $this->cacheFile."/".md5($name).".json";

          if(!file_exists($newCacheFile))
          {
              $this->cacheFiles[$name] = array(
                  'name' => $name,
                  'newFilePath' => $newCacheFile,
                  'time' => $time,
              );
              if(!is_array($value)) {
                  $values = array();
                  $values[] = $value;
              }
              @$value['time'] = $time;

              $value = json_encode($value);

              touch($newCacheFile);
              $ac = fopen($newCacheFile,"w");
              $yaz = fwrite($ac,$value);
              fclose($ac);
          }else{
              unlink($newCacheFile);
              $this->set($name,$value,$time);
          }
      }
      public function delete($name)
      {
          $file = $this->cacheFiles[$name]['newFilePath'];
          if(file_exists($file))
          {
              unlink($file);
              return true;
          }else{
              return false;
          }
      }
      public function flush()
      {
          $filePath = $this->filePath;

          if(is_dir($filePath))
          {
              $ara = scandir($filePath);

              foreach ($ara as $key ) {
                  if( $key != "." && $key != ".." && !is_dir($filePath))
                  {
                      unlink($filePath);
                  }
              }
          }
      }
}
