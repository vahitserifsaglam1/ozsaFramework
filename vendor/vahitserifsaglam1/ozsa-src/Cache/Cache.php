<?php
namespace Cache;
include $appPath."Configs/Interfaces/phpCacheInterface.php";

class Cache implements phpCacheInterface{

    public static $cacheFile;
    private static $_cache;
    private static $cache;
    private static $cacheType;
    public static  $cacheFiles;
    public static function init ( $cacheFile = "Stoge/Cache"){
        if(!file_exists($cacheFile)) mkdir($cacheFile,0777);
        if(extension_loaded('memcache')){ self::$_cache = new Memcache; self::$_cache->connect('127.0.0.1', 11211);}
        else
        {
            if(is_writeable($cacheFile))
            {

                self::$_cache = new ozsaCACHE($cacheFile);

            }else{ error::newError("$cacheFile yazılabilir bir dosya değil");}
        }
    }
    public function get($name)
    {
        return  self::$_cache->get($name);
    }
    public function set($name,$value,$time = 3600)
    {
        return  self::$_cache->set($name,$value,$time);
    }
    public function delete($name)
    {
        return  self::$_cache->delete($name);
    }
    public function flush()
    {
        return  self::$_cache->flush();
    }
    public function check($name){ self::$_cache->check($name);}
}
class ozsaCache implements phpCacheInterface{
    public  $cacheFiles;
    private $cacheFile;
    public function __construct($cache){
        $this->cacheFile = $cache;
    }
    public function get($name)
    {
        $file =$this->cacheFiles[$name]['newFilePath'];
        $time = $this->cacheFiles[$name]['time'];
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
        $this->newCacheFile = $newCacheFile;

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
            $value['time'] = $time;

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
?>