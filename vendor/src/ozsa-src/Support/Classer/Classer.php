<?php

  namespace Support\Classer;


  class Classer{


      public static function make($classname, $parametres = array())
      {

          if(class_exists($classname,false))
          {
              $parametres = \Desing\Single::unsetter(func_get_args());
              (new \ReflectionClass($classname))->newInstanceArgs($parametres);

          }else{

              return false;

          }



      }

  }