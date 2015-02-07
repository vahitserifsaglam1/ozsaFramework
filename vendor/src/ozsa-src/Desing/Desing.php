<?php
namespace Desing;

class Single
{

    public static $siniflar;

    public static $sinifSay = 0;


    public static function make($sinif, ...$parametres)

    {

        if (!isset (self::$siniflar[$sinif])) {

            self::$siniflar[$sinif] = new $sinif(...$parametres);
            self::$sinifSay++;

        }

        return self::$siniflar[$sinif];


    }


}


