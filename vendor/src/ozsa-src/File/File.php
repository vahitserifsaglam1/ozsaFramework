<?php

 Class file{
     public $in;
     public static function makeDir($path)
     {
         if(is_dir($path)) {mkdir($path);}else touch($path);
     }
     public static function delete($path)
     {
        if(is_dir($path)) rmdir($path);else unlink($path);
     }
     public static function getContent($path)
     {
         return file_get_contents($path);
     }
     public static function setContent($path,$content)
     {
         return file_put_contents($path,$content);
     }
     public static function chech($path)
     {
         if(file_exists($path)) return true;
     }
     public static function scanType($path,$type)
     {
     $pattern = $path.".{$type}";
     return glob($pattern,GLOB_BRACE);
     }
     public function in($path)
     {
         if($this->in) $this->in .= "/".$path;else $this->in .= $path;
         return $this;
     }
     public function scan($path,$type = GLOB_NOSORT,$realpath = false)
     {
         $pattern = glob($path,$type);
         if($realpath) {
            $pattern = array_map('realpath',$pattern);
         }
     }
     public static function reName($oldname,$newname)
     {
          rename($oldname,$newname);
     }
     public static function deleteAllDir($dir)
     {
         $scan = self::scan($dir,GLOB_BRACE,true);
         foreach($scan as $key)
         {
             unlink($key);
         }
     }
 }