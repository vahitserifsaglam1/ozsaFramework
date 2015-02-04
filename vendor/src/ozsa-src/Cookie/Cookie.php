<?php
class Cookie
{
    private static $OzsaIncluded = false;

    private static $cookieType;

    private static $nameHast = 'md5';

    public  static $CookieFolder;

    public static $filesystem;
    public static function init()
    {
        $configs = require APP_PATH.'Configs/cookieConfigs.php';
        self::$cookieType = $configs['type'];
        self::$CookieFolder = $configs['CookieFolder'];
        if(!file_exists(self::$CookieFolder) )  file::makeDir(self::$CookieFolder);chmod(self::$CookieFolder,0777);
    }

    public static function get($name)
    {
        $type = self::$CookieType;

        $funcname = "getCookie".$type;

        return self::$funcname($name);
    }
    public static function set($name,$value,$time = false)
    {
        $type = self::$CookieType;

        $funcname = "setCookie".$type;

        return self::$funcname($name,$value,$time);
    }
    public static function delete($name)
    {
        $type = self::$CookieType;

        $funcname = "deleteCookie".$type;

        return self::$funcname($name);
    }
    public static function flush()
    {
        $type = self::$CookieType;

        switch ($type)
        {
            case 'Php':
                foreach($_COOKIE as  $key => $value)
                {
                    unset($_COOKIE[$key]);
                }
                break;
            case 'Ozsa':
                $ara = file::scanType(self::$CookieFolder,"ozsa");
                foreach($ara as $key)
                {
                    unlink(self::$CookieFolder."/".$key);
                }
                break;
            case 'Json':
                $ara = file::scanType(self::$CookieFolder,"json");
                foreach($ara as $key)
                {
                    unlink(self::$CookieFolder."/".$key);
                }
                break;
        }
    }
    public static function setCookieJson($name,$value,$time = 1800)
    {

        $time = time()+$time;
        $array = array('time' => $time);
        $array['content'] = $value;
        $array = json_encode($array);

        self::createSesssionFile($name,$array,".json");

    }
    public static function setCookiePhp($name,$value,$time=false)
    {
        setcookie($name,$value,time()+$time);
    }
    public static function setCookieOzsa($name,$value,$time=false)
    {

        if(!self::$OzsaIncluded) self::init();
        $time = time()+$time;
        $array = array();
        $array['time'] = $time;
        $array['content'] = $value;
        $value = Ozsa::encode($array);

        self::createSesssionFile($name,".ozsa",$value);

    }
    public static function getCookieJson($name)
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
    public static function getCookiePhp($name)
    {
        if(isset($_Cookie[$name])) return $_COOKIE[$name];else return false;
    }
    public static function getCookieOzsa($name)
    {
        if(!self::$OzsaIncluded) self::init();
        return Ozsa::decode(self::readCookieFile($name,".ozsa"));
    }
    public static function deleteCookieJson($name)
    {
        $name = self::createFileName($name);
        $file = self::$CookieFolder."/".$name.".json";
        if(file::check($file))  file::delete($file);else return false;
    }
    public static function deleteCookiePhp($name)
    {
        if(isset($_Cookie[$name])) setcookie($name,'',time()-360000000);else error::newError(" $name diye bir Cookie bulunamadı ");
    }
    public static function deleteCookieOzsa($name)
    {
        $name = self::createFileName($name);
        $file = self::$CookieFolder."/".$name.".ozsa";
        if(file::check($file))  file::delete($file);else return false;
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