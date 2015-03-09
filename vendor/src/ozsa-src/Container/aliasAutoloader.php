<?php


 class aliasAutoloader
 {

     protected $alias;

     protected $registered = false;

     protected static $ins;

     public function __construct(array $alias = array() )
     {
         $this->alias = $alias;
          if(count($alias) === 0)
          {

              $this->alias = \Config::get('Configs','alias');

          }


     }



     public function getName()
     {

         return __CLASS__;

     }
     public function boot()
     {

       $this->register();

     }

     protected function load($name)
     {

         $classPath = str_replace("\\","/",$name);

         $path = "vendor/src/ozsa-src/".$classPath;


         if(file_exists($path))
         {

           include $path;

         }



     }

     public function getRegistered()
     {

         return $this->registered;

     }

     public function getAliases()
     {

         return $this->alias;

     }

     public function setRegistered($val = false)
     {

         $this->registered = $val;

     }

     protected function register()
     {
         if( !$this->getRegistered() )
         {

             spl_autoload_register(array($this, 'load'), true, true);
             $this->setRegistered(true);

         }

     }

     public static function setInstance($class)
     {

         if(is_object($class)) static::$ins = $class;

     }

     public static function getInstance( array $alias = array())
     {
         if(!static::$ins)
         {

             static::$ins = new static($alias);

         }
         return static::$ins;
     }

 }