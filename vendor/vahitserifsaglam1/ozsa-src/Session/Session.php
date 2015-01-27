<?php
namespace Session;
include $appPath."Configs/Interfaces/SessionInterface.php";

class Session implements SessionInterface
{

    /**
     * @var string
     * Desteklenen tipler , 'Php','Ozsa','Json'
     */
    private static $OzsaIncluded = false;
    private static $sessionType = 'Ozsa';
    /**
     * @var string
     * Desteklenen 'md5','sha1' ...
     */
    private static $nameHast = 'md5';

    public  static $sessionFolder;

    public static function init()
    {
        if(!file_exists(self::$sessionFolder) ) mkdir(self::$sessionFolder);chmod(self::$sessionFolder,0777);
       self::$sessionFolder = $appPath.'Stroge/Sessions';
    }

    public static function get($name)
    {
        $type = self::$sessionType;

        $funcname = "getSession".$type;

        return self::$funcname($name);
    }
    public static function set($name,$value,$time = false)
    {
        $type = self::$sessionType;

        $funcname = "setSession".$type;

        return self::$funcname($name,$value);
    }
    public static function delete($name)
    {
        $type = self::$sessionType;

        $funcname = "deleteSession".$type;

        return self::$funcname($name);
    }
    public static function flush()
    {
        $type = self::$sessionType;

        switch ($type)
        {
            case 'Php':
                foreach($_SESSION as $key => $value)
                {
                    unset($_SESSION[$key]);
                }
                break;
            case 'Ozsa':
                $ara = File::scanType(self::$sessionFolder,"ozsa");
                foreach($ara as $key)
                {
                    unlink(self::$sessionFolder."/".$key);
                }
                break;
            case 'Json':
                $ara = File::scanType(self::$sessionFolder,"json");
                foreach($ara as $key)
                {
                    unlink(self::$sessionFolder."/".$key);
                }
                break;
        }
    }
    public static function setSessionJson($name,$value,$time = 1800)
    {

        $time = time()+$time;
        $array = array('time' => $time);
        $array['content'] = $value;
        $array = json_encode($array);

        self::createSesssionFile($name,$array,".json");

    }
    public static function setSessionPhp($name,$value,$time=false)
    {
        $_SESSION[$name] = $value;
    }
    public static function setSessionOzsa($name,$value,$time=false)
    {
        if(!self::$OzsaIncluded) include $appPath."Lib/Ozsa.php"; self::$OzsaIncluded = true;
        $time = time()+$time;
        $array = array();
        $array['time'] = $time;
        $array['content'] = $value;
        $value = Ozsa::encode($array);
        self::createSesssionFile($name,".ozsa",$value);

    }
    public static function getSessionJson($name)
    {

        $don =  self::readSessionFile($name,".json");
        $value =  json_decode($don);
        $file = self::createFileName($name).".json";
        $filetime = filemtime($file);
        if($filetime>$value->time)
        {
            self::deleteSessionJson($name);
        }else{
            return $value->content;
        }
    }
    public static function getSessionPhp($name)
    {
        if(isset($_SESSION[$name])) return $_SESSION[$name];else return false;
    }
    public static function getSessionOzsa($name)
    {
        if(!self::$OzsaIncluded) include $appPath."Lib/Ozsa.php"; self::$OzsaIncluded = true;;
        return Ozsa::decode(self::readSessionFile($name,".ozsa"));
    }
    public static function deleteSessionJson($name)
    {
        $name = self::createFileName($name);
        $file = self::$sessionFolder."/".$name.".json";
        if(file::check($file))  file::delete($file);else return false;
    }
    public static function deleteSessionPhp($name)
    {
        if(isset($_SESSION[$name])) unset($_SESSION[$name]);else error::newError(" $name diye bir session bulunamadı ");
    }
    public static function deleteSessionOzsa($name)
    {
        $name = self::createFileName($name);
        $file = self::$sessionFolder."/".$name.".ozsa";
        if(file::check($file))  file::delete($file);else return false;
    }
    public static function createSesssionFile($name,$ext,$content)
    {
        $name = self::createFileName($name);

        $file = self::$sessionFolder."/".$name.$ext;

        if(!file_exists($file))
        {
            touch($file);
            chmod($file,0777);
            file::write($file,$content,false);
        }else{
            file::write($file,$content,false);
        }

        return $file;

    }
    public static function readSessionFile($name,$ext)
    {
        $name = self::createFileName($name);

        $file = self::$sessionFolder."/".$name.$ext;

        $oku = file::open($file,false);

        if($oku) return $oku;else return false;
    }
    public static function createFileName($name)
    {
        $typ = self::$nameHast;

        return $typ($name);
    }
}