<?php

  class Mailer {
      public static function send($name = '',Callable $call)
      {

           if( !is_array( $name ) )
           {
               $options = require APP_PATH.'Configs/Mail/'.$name.'.php';
           }else{

               $options = $name;
           }


           $message = Desing\Single::make('Mail',$options);

           return $call($message);
      }
  }