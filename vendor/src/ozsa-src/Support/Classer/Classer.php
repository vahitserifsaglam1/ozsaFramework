<?php

  namespace Support\Classer;


  class Classer{


      public static function make($classname,...$options)
      {

          if(class_exists($classname,false))
          {

              return new $classname(...$options);

          }else{

              return false;

          }



      }

  }