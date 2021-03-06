<?php

/**
 * Class Config
 *
 *   Sınıflar içinden configleri çekmek için kullanılacak sınıf
 */

  class Config{

      protected $check;

      protected static $configPath;

      protected static $ins;

      protected static $configs;

      /**
       *
       *  Başlatıcı Sınıf
       *
       *   configs dosyalarının yolunu gösterir
       */

      public function __construct()
      {

          static::$configPath = APP_PATH.'Configs';

          (file_exists(static::$configPath)) ? $this->check = true:$this->check = false;



      }

      /**
       * @return mixed
       *  Static olarak sınıfı başlatmak için kullanılır
       */

      public static function boot()
      {

          if(!static::$ins)
          {

              static::$ins = new static();

          }

          return static::$ins;

      }

      /**
       * @param $name
       * @param null $config
       * @return bool|mixed
       *  Conif i çekmek için kullanılır
       */

      public static  function get($name,$config = null)
      {

          if(!static::$ins)  static::boot();

          $path = static::$configPath.'/'.$name.'.php';


          if(!isset(static::$configs[$name]))
          {

              $configs = include $path;

              static::$configs[$name] = $configs;



          }

          $configs = static::$configs[$name];

          if($config !== null){


              $configs = $configs[$config];


          }

          return $configs;





      }

      /**
       * @param $name
       * @param null $configs
       * @param null $value
       * @return null
       *
       *  Configi ayarlamak için kullanılır
       */
      public static function set($name,$configs = null,$value = null)
      {

          if(!static::$ins)  new static();

          if( is_array($configs) )
          {

              static::$configs = $configs;

          }
          elseif(  is_string($configs) && $value && $value !== null )
          {

              static::$configs[$configs] = $value;

          }

          return $value;

      }

  }