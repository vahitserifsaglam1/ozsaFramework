<?php

class ozsaSession implements ozsaSessionInterface
{
    public static $initted = false;
    public static $sessionFolder;
    public static $nameHast = 'md5';

    public static function init()
    {
        $configs = require 'Configs/Configs.php';
        $configs = $configs['Session'];
        self::$sessionType = $configs['type'];
        self::$sessionFolder = APP_PATH . 'Stroge/Session';
        if (!file_exists(self::$sessionFolder)) file::makeDir(self::$sessionFolder);
        chmod(self::$sessionFolder, 0777);
    }

    public static function set($name, $value, $time = false)
    {

        if (!self::$initted == false) self::init();
        $time = time() + $time;
        $array = array();
        $array['time'] = $time;
        $array['content'] = $value;
        $value = Ozsa::encode($array);

        self::createSesssionFile($name, ".ozsa", $value);

    }

    public static function get($name)
    {
        if (!self::$initted == false) self::init();
        return Ozsa::decode(self::readSessionFile($name, ".ozsa"));
    }

    public static function delete($name)
    {
        if (!self::$initted == false) self::init();
        $name = self::createFileName($name);
        $file = self::$sessionFolder . "/" . $name . ".ozsa";
        if (file::check($file)) file::delete($file); else return false;
    }

    public static function flush()
    {
        if (!self::$initted == false) self::init();
        $ara = file::scanType(self::$sessionFolder, "ozsa");
        foreach ($ara as $key) {
            unlink(self::$sessionFolder . "/" . $key);
        }
    }

    public static function createSesssionFile($name, $ext, $content)
    {
        $name = self::createFileName($name);

        $file = self::$sessionFolder . "/" . $name . $ext;

        if (!file_exists($file)) {
            touch($file);
            chmod($file, 0777);
            file::setContent($file, $content);
        } else {
            file::setContent($file, $content);
        }

        return $file;

    }

    public static function readSessionFile($name, $ext)
    {
        $name = self::createFileName($name);

        $file = self::$sessionFolder . "/" . $name . $ext;

        $oku = file::getContent($file, false);

        if ($oku) return $oku['content']; else return false;
    }

    public static function createFileName($name)
    {
        $typ = self::$nameHast;

        return $typ($name);
    }
}
