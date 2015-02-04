<?php


   interface jsonSessionInterface{
       public static function init();
       public static function get($name);
       public static function set($name,$value,$time);
       public static function delete($name);
       public static function flush();
       public static function createSesssionFile($name,$ext,$content);
       public static function readSessionFile($name,$ext);
       public static function createFileName($name);

   }