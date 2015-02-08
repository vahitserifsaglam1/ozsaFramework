<?php
namespace App;

 Class Router

 {

      protected $url;

      protected $booted = false;

      public function __construct()
      {



      }

     public static function  boot()
     {
         $cek = require APP_PATH.'Configs/Configs.php';

         $url = $cek['URL'];

         static::$url = $url;
     }


      public static function get($url, $callable )
      {
         if( !static::$booted ) static::boot();


      }
 }