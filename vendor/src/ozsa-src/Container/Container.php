<?php



 class Container
 {

     const  PROVIDER = 'Container\Providers';

     public  $configs = array();

     protected $aliases = array();

     protected $providers = array();


     public function __construct()
     {

         $configs = Config::get('Configs');

         $this->configs = $configs;

         $this->aliases = $this->configs['alias'];

         $this->providers = $this->configs['providers'];

     }

      public function isAlias($name)
      {

           if(isset($this->aliases[$name])) return true;else return false;

      }

     public function callAlias($name)
     {

         return $this->aliases[$name];

     }


     public function returnAliases()
     {

         return $this->aliases;

     }

     protected function providerNameCreator($name)
     {

        return $name = static::PROVIDER.'\\'.$name.'Provider';

     }

     public function isProvider($name)
     {

         $name = $this->providerNameCreator($name);

         if( isset ( $this->providers[$name] ) ) return true;else return false;

     }

     public function addAlias($name,$namaspace)
     {

         $this->aliases[$name] = $namaspace;

     }

     public function addAliases(array $array = array() )
     {

         $this->aliases = array_merge($this->aliases,$array);

     }

     public function callProvider($name)
     {

       $name = $this->providerNameCreator($name);

         return $this->providers[$name];

     }

     public function returnProviders()
     {

         return $this->providers;

     }

     public function registerProvider($namespace = '')
     {

         if( !in_array($namespace,$this->providers))
         {

             $this->providers[] = $namespace;

         }

     }



 }