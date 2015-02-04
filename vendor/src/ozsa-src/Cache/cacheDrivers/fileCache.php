<?php

namespace Cache;

 class fileCache implements \fileCacheInterface {
     private static $cache;
     private static $cacheType;
     public  static  $cacheFiles;
     public static   $newCacheFile;
     public  static  $cacheFile;
     public static    $initted = false;
     public static function init()
     {
         $configs = require 'Configs/Configs.php';
         $path = $configs['Cache']['CacheFolder'];
         self::$cacheFile = $path;
         self::$initted = true;
     }
     public static function get($name)
     {

         $cacheFiles = self::$cacheFiles;

         $file =$cacheFiles[$name]['newFilePath'];
         $time = $cacheFiles[$name]['times'];
         if(file_exists($file)){
             $value = file_get_contents($file);
             $value = json_decode($value);

             if( is_object($value) )
             {

                 if(filemtime($file) < time() - $value->times){return false; } else{

                     return $value->content;
                 }
             }
         }else{return false;}
     }
     public  static function  check($name){
         $file = self::$cacheFiles[$name]['newFilePath'];
         return (file_exists($file)) ? true:false;
     }
     public static  function set($name,$value,$times = 3600)
     {
         $newCacheFile = self::$cacheFile."/".md5($name).".json";

         if(!file_exists($newCacheFile))
         {
             self::$cacheFiles[$name] = array(
                 'name' => $name,
                 'newFilePath' => $newCacheFile,
                 'times' => $times,
             );

             if(!is_array($value)) {
                 $values = array();
                 $values['content'] = $value;

                 @$values['times'] = $times;
             }



             $value = json_encode($values);

             touch($newCacheFile);
             $ac = fopen($newCacheFile,"w");
             $yaz = fwrite($ac,$value);
             fclose($ac);
         }else{
             unlink($newCacheFile);
             self::set($name,$value,$times);
         }

     }
     public  static function delete($name)
     {
         $file = self::$cacheFiles[$name]['newFilePath'];
         if(file_exists($file))
         {
             unlink($file);
             return true;
         }else{
             return false;
         }

     }
     public static  function flush()
     {
         $filePath = self::$filePath;

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

     public static function __callStatic($name,$params)
     {
          if(!self::$initted) self::init();
         return call_user_func_array(array('Cache\fileCache',$name),$params);
     }

 }