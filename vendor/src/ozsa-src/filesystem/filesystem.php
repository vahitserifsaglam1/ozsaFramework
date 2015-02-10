<?php


   class Filesystem
   {

       public $adapter;


       public $disk;


       public function __construct( $boot  = 'Local' )
       {

            $this->disk = $boot;

            $this->adapter = \Desing\Single::make('\Adapter\Adapter','Filesystem');

            $this->adapter->addAdapter(\Desing\Single::make('\Filesystem\Filesystem'.$boot));

       }

       public static function boot( $boot='Local' )
       {
           return new static( $boot );
       }
       public static function disk( $boot = 'Local' )
       {

           return new static( $boot );

       }

       public static function __callStatic( $name, $params)
       {
           $s = new static();
           return call_user_func_array(array($s->adapter,$name),$params);

       }
       public function __call( $name, $params )
       {
           $namef = "Filesystem".$this->disk;
           return call_user_func_array(array($this->adapter->$namef,$name),$params);

       }


   }