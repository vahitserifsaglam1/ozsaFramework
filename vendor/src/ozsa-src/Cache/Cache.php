<?php


  class Cache {

      private  $_cache;

      private  $_cacheBase = array(
          'memcache' => true,'apc' => true,'file' => false,
      );

      public  function __construct($return = false)
      {
          $this->boot();

      }

      public function boot()
      {
          $configs = require APP_PATH.'Configs/Configs.php';

          $configs = $configs['Cache'];

          $type = $configs['type'];



          if(isset($this->_cacheBase[$type]))
          {


                   switch($type)
                   {
                       case 'memcache':

                              if ( extension_loaded('memcache') )
                              {

                                  $this->_cache = new Memcache;

                                  $this->_cache->connect("127.0.0.1",11211);

                              }

                           break;

                       case 'apc':

                            if ( function_exists ('apc_cache_info') )
                            {

                                $this->_cache = new Cache\apcCache();

                            }

                           break;

                       case 'file':

                               if ( class_exists( 'Cache\fileCache') )

                               {
                                   $this->_cache = new Cache\fileCache();
                               }
                               else{

                               }

                           break;
                   }



          }else{
              throw new Exception($type. 'Bu sınıf desteklenmemektedir');
          }
      }

   public function __call($name,$params)
   {

        return call_user_func_array(array($this->_cache,$name),$params);

   }
      public static function __callStatic($name,$params)
      {
          $s = new static(true);

          return call_user_func_array(array($s->_cache,$name),$params);

      }

  }

