<?php
namespace File\File;
class File {
    public static function render($path,$app=true)
    {
        if($app) $path = $appPath.$path;
        if(file_exists($path))
        {
            include $path;
        }else{
            return false;
        }
    }
    public static function open($path,$app=true)
    {
        if($app) $path = $appPath.$path;

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
    public  static function write($path,$write,$app=true)
    {
        if($app) $path = $appPath.$path;

        if(file_exists($path)){
            $ac = fopen($path,"w");
            $yaz = fwrite($ac,$write);
            fclose($ac);
        }else{
            error::newError("$path Böyle bir dosya bulunamadı");
            return false;
        }
    }
    public static function delete($path,$app=true)
    {
        if($app) $path = $appPath.$path;
        if(file_exists($path)){ if(is_dir($path))rmdir($path);else unlink($path);}else{return false;}
    }
    public static function scanDir($dir)
    {
        $pattern = $dir."*";
        return  glob($pattern,GLOB_ONLYDIR);
    }
    public static function scanType($dir,$type)
    {
        $pattern = $dir.".{$type}";
        return glob($pattern,GLOB_BRACE);
    }
    public static function check($path,$app=true)
    {
        if($app) $path = $appPath.$path;
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
            if( count($params) > 0)
            {
                return call_user_func_array($name, $params);
            }else{
                return $name();
            }
        }
    }
}
